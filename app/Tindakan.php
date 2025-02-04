<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = 'emanagement.tindakan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_tindakan';
    protected $fillable = [
        'id_permohonan', 'no_kenderaan_pergi', 'pemandu_pergi', 'hp_pemandu_pergi',
        'no_kenderaan_balik', 'pemandu_balik', 'hp_pemandu_balik', 'id_bilik',
        'catatan', 'id_status_kenderaan', 'id_status_bilik', 'id_status_tempah', 
        'peg_penyelia', 'updated_by', 'created_by',
    ];
}
