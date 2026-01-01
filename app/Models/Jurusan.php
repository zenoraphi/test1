<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'jurusan',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'id_jurusan');
    }
}
