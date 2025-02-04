<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpKaterer extends Model

{
    protected $table = 'emanagement.lkp_katerer';
    public $timestamps = false;

    protected $primaryKey = 'id_katerer';
    protected $fillable = [
        'nama_katerer','alamat', 'tkh_mula', 'tkh_mula', 'person_in_charge', 'emel', 'no_tel_katerer'
    ];

    
}
