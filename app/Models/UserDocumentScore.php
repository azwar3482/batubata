<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'extracted_skills',
        'skill_embedding_vector',
        'overall_score',
        'processed_at',
    ];

    protected $casts = [
        'extracted_skills'       => 'array',
        'overall_score'          => 'decimal:2',
        'processed_at'           => 'datetime',
    ];

    // === RELASI ===

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(UserDocument::class, 'document_id');
    }

    // === HELPERS ===

    /**
     * Mengambil skill_embedding_vector sebagai array PHP.
     * Kolom disimpan sebagai JSON string longtext untuk efisiensi.
     */
    public function getEmbeddingVectorArray(): array
    {
        if (!$this->skill_embedding_vector) return [];
        return json_decode($this->skill_embedding_vector, true) ?? [];
    }
}
