<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocumentWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'cv_weight',
        'ijazah_weight',
        'transkrip_weight',
        'sertifikat_weight',
        'portofolio_weight',
        'is_active',
    ];

    protected $casts = [
        'cv_weight'          => 'decimal:2',
        'ijazah_weight'      => 'decimal:2',
        'transkrip_weight'   => 'decimal:2',
        'sertifikat_weight'  => 'decimal:2',
        'portofolio_weight'  => 'decimal:2',
        'is_active'          => 'boolean',
    ];

    // === RELASI ===

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // === SCOPES ===

    /**
     * Ambil konfigurasi bobot default (company_id = null).
     */
    public function scopeDefault($query)
    {
        return $query->whereNull('company_id')->where('is_active', true);
    }

    // === HELPERS ===

    /**
     * Mengembalikan total semua bobot untuk validasi (seharusnya 100).
     */
    public function getTotalWeightAttribute(): float
    {
        return $this->cv_weight + $this->ijazah_weight + $this->transkrip_weight
             + $this->sertifikat_weight + $this->portofolio_weight;
    }

    /**
     * Kembalikan bobot sebagai array asosiatif dengan kunci sesuai document_type.
     */
    public function toWeightArray(): array
    {
        return [
            'cv'          => (float) $this->cv_weight,
            'ijazah'      => (float) $this->ijazah_weight,
            'transkrip'   => (float) $this->transkrip_weight,
            'sertifikat'  => (float) $this->sertifikat_weight,
            'portofolio'  => (float) $this->portofolio_weight,
        ];
    }
}
