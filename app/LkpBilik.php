<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpBilik extends Model

{
    protected $table = 'dd_kpn.lkp_bilik';
    public $timestamps = false;

    protected $primaryKey = 'id_bilik';
    protected $fillable = [
        'bilik','id_bahagian', 'aras', 'kapasiti_bilik', 'gambar_bilik', 'kemudahan_bilik'
    ];

    
}
