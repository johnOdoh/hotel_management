<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Guarded(['id'])]
class RoomCategory extends Model
{
    use HasFactory, HasUlids;

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'features' => 'array',
            'amount' => 'decimal:2',
            'capacity' => 'integer',
            'size' => 'float',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($model) {
            foreach ($model->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        });
    }

    public function rooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Room::class, 'room_category_id');
    }
}
