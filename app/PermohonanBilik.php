<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermohonanBilik extends Model
{
    protected $table = 'emanagement.permohonan_bilik';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_permohonan_bilik';
    protected $fillable = [
        'id_pemohon', 'kod_permohonan', 'tkh_mula', 'masa_mula','tkh_hingga', 'masa_hingga','id_bilik', 'id_tujuan',
        'id_status', 'catatan', 'nama_pengerusi', 'bil_peserta', 'nama_meeting', 'tempah_makan', 'lampiran',
        'updated_at', 'created_at',
    ];
}
