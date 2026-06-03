<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description'];

    /**
     * Relasi: Posisi yang menggunakan kategori ini (match by name)
     */
    public function positions()
    {
        return $this->hasMany(Position::class, 'category', 'name');
    }

    /**
     * Relasi: Kompetensi yang menggunakan kategori ini
     */
    public function competencies()
    {
        return $this->hasMany(Competency::class, 'category', 'name');
    }

    /**
     * Hitung jumlah posisi di kategori ini
     */
    public function getPositionsCountAttribute()
    {
        return $this->positions()->count();
    }

    /**
     * Hitung jumlah kompetensi di kategori ini
     */
    public function getCompetenciesCountAttribute()
    {
        return $this->competencies()->count();
    }
}
