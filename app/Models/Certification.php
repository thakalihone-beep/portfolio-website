<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'issuer',
        'issuer_logo',
        'credential_id',
        'credential_url',
        'certificate_file',
        'issue_date',
        'expiry_date',
        'does_not_expire',
        'description',
        'sort_order',
        'is_featured',
        'is_active',
        'certificate_image',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
            'does_not_expire' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
