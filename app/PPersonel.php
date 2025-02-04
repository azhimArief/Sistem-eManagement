<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPersonel extends Model
{
    protected $table = 'personel.pegawais';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    //untuk primary yg bukan increment
    // public $incrementing = false;
    
    protected $fillable = [
        'name', 'nokp', 'jawatan', 'gred', 'email', 'tel_bimbit', 'agensi', 'bahagian_id', 'bahagian', 'tel'
    ];
}
