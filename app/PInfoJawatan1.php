<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PInfoJawatan extends Model
{
    protected $table = 'personel.info_jawatan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'no_kp';
    protected $fillable = [
        ''
    ];
}
