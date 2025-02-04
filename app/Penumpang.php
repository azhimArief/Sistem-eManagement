<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penumpang extends Model
{
    protected $table = 'emanagement.penumpang';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_penumpang';
    protected $fillable = [
        
        'mykad','nama', 'bahagian', 'no_tel','emel', 'id_tempahan',
    ];

}