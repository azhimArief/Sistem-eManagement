<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJenisPerjalanan extends Model
{
    protected $table = 'emanagement.lkp_jenis_perjalanan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_jenis_perjalanan';
    protected $fillable = [
        'jenis_perjalanan',
    ];
}
