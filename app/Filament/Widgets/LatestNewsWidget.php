<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\Complaint;
use Filament\Widgets\Widget;

class LatestNewsWidget extends Widget
{
    protected string $view = 'filament.widgets.latest-news-widget';

    protected string|array|int $columnSpan = 'full';

    public static function canView(): bool
    {
        return request()->user()->profile()->exists();
    }

    protected function getViewData(): array
    {
        return [
            'news' => Announcement::latest()->take(3)->get(),
            'complaints' => Complaint::latest()->take(5)->get(),
        ];
    }
}
