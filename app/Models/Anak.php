<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'tb_anak';

    protected $fillable = [
        'name',
        'name_ibu',
    ];

    public function detailAnak()
    {
        return $this->hasMany(DetailAnak::class, 'id_anak');
    }

    public function detailBantuan()
    {
        return $this->hasMany(DetailBantuan::class, 'id_anak');
    }
}
