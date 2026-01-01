<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $table = 'pembimbing';
    protected $primaryKey = 'id_pembimbing';

    protected $fillable = [
        'nama',
        'nip',
        'id_jurusan',
        'pangkat',
        'golongan',
        'jabatan',
        'jumlah_jam_mengajar',
        'no_hp',
        'foto',
        'user_id',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_pembimbing', 'id_pembimbing');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    // INI YANG BENAR
    public function dudis()
    {
        return $this->belongsToMany(
            Dudi::class,
            'pembimbing_dudi',
            'id_pembimbing',
            'id_dudi'
        );
    }
}
