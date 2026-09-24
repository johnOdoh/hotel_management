<?php

namespace App\Models;

use App\Enums\EmploymentStatus;
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
        ];
    }
}
