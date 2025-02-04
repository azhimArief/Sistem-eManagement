<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kenderaan extends Model
{
    protected $table = 'emanagement.kenderaan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_kenderaan';
    protected $fillable = [
        'model', 'no_plat', 'pemandu', 'id_jenis', 'Bil_penumpang', 'id_status',
    ];
}
