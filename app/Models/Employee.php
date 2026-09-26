<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
use App\Enums\Position;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

#[Unguarded]
class Employee extends Model
{
    use HasUlids;

    protected function casts()
    {
        return [
            'employment_status' => EmploymentStatus::class,
            'account_details' => 'array',
            'emergency_contact_details' => 'array',
            'employment_date' => 'date',
            'termination_date' => 'date',
            'position' => Position::class,
        ];
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function getColorAttribute(): string
    {
        // Palette of refined, modern vibrant colors suitable for cards with white text
        $palette = [
            '#2563eb', // Blue 600
            '#7c3aed', // Violet 600
            '#059669', // Emerald 600
            '#d97706', // Amber 600
            '#db2777', // Pink 600
            '#0284c7', // Sky 600
            '#4f46e5', // Indigo 600
            '#0d9488', // Teal 600
            '#e11d48', // Rose 600
            '#9333ea', // Purple 600
            '#ea580c', // Orange 600
            '#16a34a', // Green 600
        ];

        $index = abs(crc32($this->id.$this->name)) % count($palette);

        return $palette[$index];
    }
}
