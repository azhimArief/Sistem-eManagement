<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempahMakan extends Model
{
    protected $table = 'emanagement.tempah_makan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_tempah_makan';
    protected $fillable = [
        'id_permohonan_bilik', 'makan_pagi', 'id_jenis_hidangan1', 'kalori_pagi', 'makan_tghari', 'id_jenis_hidangan2', 'kalori_tengahari', 'minum_petang', 
        'menu_pagi', 'id_jenis_hidangan3', 'kalori_petang' ,'menu_tghari', 'menu_petang', 'pembekal', 'created at', 'updated_at'
    ];
}
