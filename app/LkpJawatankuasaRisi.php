<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJawatankuasaRisi extends Model
{
    protected $table = 'risi.lkp_jawatankuasa_risi';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_jawatan';
    protected $fillable = [
        'nama_jawatan',
    ];
}
