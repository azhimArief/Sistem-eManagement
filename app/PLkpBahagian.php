<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PLkpBahagian extends Model
{
    protected $table = 'personel.bahagian';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'bahagian', 'singkatan', 'agensi_id'
    ];
}
