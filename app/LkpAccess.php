<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpAccess extends Model
{
    protected $table = 'emanagement.lkp_access';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_access';
    protected $fillable = [
        'access_type',
    ];
}
