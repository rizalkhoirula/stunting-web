<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBantuan extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_bantuan';

    protected $fillable = [
        'id_bantuan',
        'id_anak',
        'jumlah'
    ];

    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class, 'id_bantuan');
    }

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak');
    }
}
