<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpDaerah extends Model
{
    protected $table = 'risi.lkp_daerah';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_daerah';
    protected $fillable = [
        'daerah', 'id',
    ];
}
