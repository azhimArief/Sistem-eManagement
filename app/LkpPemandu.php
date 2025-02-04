<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpPemandu extends Model
{
    protected $table = 'emanagement.lkp_pemandu';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'mykad';
    
    //untuk primary yg bukan increment
    public $incrementing = false;

    protected $fillable = [
        'mykad','nama_pemandu','gred_pemandu', 'bahagian', 'no_tel_bimbit',
    ];
}
