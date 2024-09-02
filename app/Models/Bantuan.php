<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bantuan extends Model
{
    use HasFactory;

    protected $table = 'tb_bantuan';

    protected $fillable = [
        'name'
    ];

    public function detailBantuan()
    {
        return $this->hasMany(DetailBantuan::class, 'id_bantuan');
    }
}
