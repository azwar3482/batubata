<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    // Konstanta tipe dokumen yang didukung sistem
    const TYPE_CV           = 'cv';
    const TYPE_IJAZAH       = 'ijazah';
    const TYPE_TRANSKRIP    = 'transkrip';
    const TYPE_SERTIFIKAT   = 'sertifikat';
    const TYPE_PORTOFOLIO   = 'portofolio';

    const TYPES = [
        self::TYPE_CV         => 'Curriculum Vitae (CV)',
        self::TYPE_IJAZAH     => 'Ijazah',
        self::TYPE_TRANSKRIP  => 'Transkrip Nilai',
        self::TYPE_SERTIFIKAT => 'Sertifikat',
        self::TYPE_PORTOFOLIO => 'Portofolio',
    ];

    // Status pemrosesan dokumen
    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED  = 'completed';
    const STATUS_FAILED     = 'failed';

    protected $fillable = [
        'user_id',
        'document_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'status',
        'notes',
    ];

    // === RELASI ===

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function score()
    {
        return $this->hasOne(UserDocumentScore::class, 'document_id');
    }

    // === SCOPES ===

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    // === HELPERS ===

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING    => '⏳ Menunggu Analisis',
            self::STATUS_PROCESSING => '🔄 Sedang Diproses',
            self::STATUS_COMPLETED  => '✅ Selesai',
            self::STATUS_FAILED     => '❌ Gagal',
            default => 'Unknown',
        };
    }

    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_size) return '-';
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
}
