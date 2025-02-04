<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'mybooking.permohonan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_permohonan';
    protected $fillable = [
        'mykad', 'nama', 'pohon_bagi', 'gred', 'jawatan', 'bahagian',
        'telefon', 'tel_bimbit','emel', 'udpated_by','created_by',
    ];

}