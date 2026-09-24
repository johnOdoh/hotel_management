<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NigeriaLocationService
{
    protected const CACHE_KEY = 'nigeria_states_and_lgas_data';

    /**
     * Get all states and their LGAs.
     *
     * @return array<string, array<int, string>>
     */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $filePath = resource_path('data/nigeria-states-and-lgas.json');

            if (file_exists($filePath)) {
                $contents = file_get_contents($filePath);
                $decoded = json_decode($contents, true);
                if (is_array($decoded) && ! empty($decoded)) {
                    return $decoded;
                }
            }

            // Fallback: Fetch from public API if local file is missing or invalid
            return self::fetchFromApi();
        });
    }

    /**
     * Get list of states formatted as options for Filament Select [ 'State' => 'State' ].
     *
     * @return array<string, string>
     */
    public static function getStates(): array
    {
        $all = self::all();
        $states = array_keys($all);
        sort($states);

        return array_combine($states, $states) ?: [];
    }

    /**
     * Get list of LGAs for a given state formatted as options for Filament Select [ 'LGA' => 'LGA' ].
     *
     * @return array<string, string>
     */
    public static function getLgasForState(?string $state): array
    {
        if (blank($state)) {
            return [];
        }

        $all = self::all();
        $cleanedState = trim($state);

        // Direct key lookup
        if (isset($all[$cleanedState])) {
            $lgas = $all[$cleanedState];

            return array_combine($lgas, $lgas) ?: [];
        }

        // Case-insensitive / alias lookup (e.g. 'fct' -> 'Federal Capital Territory')
        $normalizedState = strtolower($cleanedState);
        if ($normalizedState === 'fct' || $normalizedState === 'abuja') {
            $normalizedState = 'federal capital territory';
        }

        foreach ($all as $stateName => $lgas) {
            $currentNormalized = strtolower($stateName);
            if ($currentNormalized === $normalizedState || str_contains($currentNormalized, $normalizedState)) {
                return array_combine($lgas, $lgas) ?: [];
            }
        }

        return [];
    }

    /**
     * Fallback to fetch states and LGAs from an external API if needed.
     *
     * @return array<string, array<int, string>>
     */
    public static function fetchFromApi(): array
    {
        try {
            // Using devhammed's raw dataset gist
            $response = Http::timeout(5)->get('https://gist.githubusercontent.com/devhammed/0bb9eeac9ff22c895100d072f489dc98/raw/nigeria-state-and-lgas.json');

            if ($response->successful()) {
                $raw = $response->json();
                $result = [];

                if (is_array($raw)) {
                    foreach ($raw as $item) {
                        if (isset($item['state']) && isset($item['lgas']) && is_array($item['lgas'])) {
                            $name = trim($item['state']);
                            $lgas = array_values(array_filter(array_map('trim', $item['lgas'])));
                            sort($lgas);
                            $result[$name] = $lgas;
                        }
                    }
                    ksort($result);

                    if (! empty($result)) {
                        return $result;
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Failed to fetch Nigeria states/LGAs from external API: '.$e->getMessage());
        }

        return [];
    }
}
