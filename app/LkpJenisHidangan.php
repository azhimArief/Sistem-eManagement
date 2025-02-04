<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJenisHidangan extends Model
{
    protected $table = 'emanagement.lkp_jenis_hidangan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_jenis_hidangan';
    protected $fillable = [
        'jenis_hidangan',
    ];
}
