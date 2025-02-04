<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpModel extends Model
{
    protected $table = 'emanagement.lkp_model';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_model';
    protected $fillable = [
        'jenis_model', 
    ];
}
