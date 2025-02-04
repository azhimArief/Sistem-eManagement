<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuMakan extends Model
{
    protected $table = 'emanagement.menu_makan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_menu_makan';
    protected $fillable = [
        'id_tempah_makan', 'menu', 'kalori', 'jenis_makan'
    ];
}
