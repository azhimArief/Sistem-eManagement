<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpStatus extends Model
{
    protected $table = 'emanagement.lkp_status';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_status';
    protected $fillable = [
        'status',
    ];
}
