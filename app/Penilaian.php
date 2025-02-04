<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'emanagement.penilaian';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_penilaian';
    protected $fillable = [
        
        'id_maklumat_permohonan','mykad_penumpang','mykad_pemandu', 'soalan1', 'skala1','soalan2', 'skala2','soalan3', 'skala3','soalan4', 'skala4','soalan5', 'skala5','ulasan', 'komen_pemandu', 'created_at', 'updated_at'
    ];

}