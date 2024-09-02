<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'tb_sub_kriteria';

    protected $fillable = [
        'name',
        'bobot',
        'id_kriteria',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function detailAnak()
    {
        return $this->hasMany(DetailAnak::class, 'id_sub_kriteria');
    }
}
