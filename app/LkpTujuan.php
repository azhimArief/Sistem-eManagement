<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpTujuan extends Model
{
    protected $table = 'emanagement.lkp_tujuan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_tujuan';
    protected $fillable = [
        'tujuan', 
    ];
}
