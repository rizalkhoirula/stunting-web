<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'tb_kriteria';

    protected $fillable = [
        'name',
        'bobot',
        'jenis',
    ];

    public function detailAnak()
    {
        return $this->hasMany(DetailAnak::class, 'id_kriteria');
    }

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria');
    }
}
