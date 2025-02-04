<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaklumatPermohonan extends Model
{
    protected $table = 'emanagement.permohonan_kenderaan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_maklumat_permohonan';
    protected $fillable = [
        'id_pemohon', 'kod_permohonan', 'tkh_pergi', 'tkh_balik', 'masa_pergi', 'masa_balik', 
	'id_jenis_perjalanan', 'id_tujuan', 'id_status', 'catatatn', 'bil_penumpang',
        'lokasi_tujuan', 'lampiran',
		'updated_by', 'created_by',
    ];
}
