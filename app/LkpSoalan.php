<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpSoalan extends Model
{
    protected $table = 'emanagement.lkp_soalan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_soalan';
    protected $fillable = [
        'soalan',
    ];
}
