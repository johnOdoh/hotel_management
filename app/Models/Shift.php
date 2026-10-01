<?php

namespace App\Models;

use App\Enums\Position;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Unguarded]
class Shift extends Model
{
    use HasUlids;

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'position' => Position::class,
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
