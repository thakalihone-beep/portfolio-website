<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'name',
        'note_image',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
