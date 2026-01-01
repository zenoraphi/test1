<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    use HasFactory;

    protected $table = 'dudi';
    protected $primaryKey = 'id_dudi';

    protected $fillable = [
        'nama',
        'alamat',
        'pimpinan',
        'pembimbing_dudi',
        'jabatan',
        'daya_tampung',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_dudi', 'id_dudi');
    }

    // RELASI YANG KURANG
    public function pembimbings()
    {
        return $this->belongsToMany(
            Pembimbing::class,
            'pembimbing_dudi',
            'id_dudi',
            'id_pembimbing'
        );
    }

    public function isPenuh(): bool
    {
        if ($this->relationLoaded('siswas')) {
            return $this->siswas->count() >= $this->daya_tampung;
        }

        return $this->siswas()->count() >= $this->daya_tampung;
    }

    public function sisaKuota(): int
    {
        return max(0, $this->daya_tampung - $this->siswas()->count());
    }
}
