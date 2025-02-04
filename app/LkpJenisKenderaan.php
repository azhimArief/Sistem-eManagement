<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJenisKenderaan extends Model
{
    protected $table = 'emanagement.lkp_jenis_kenderaan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_jenis_kenderaan';
    protected $fillable = [
        'jenis_kenderaan',
    ];
}
