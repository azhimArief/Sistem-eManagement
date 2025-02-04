<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPersonel extends Model
{
    protected $table = 'personel.personel';
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
