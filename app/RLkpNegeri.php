<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RLkpNegeri extends Model
{
    protected $table = 'risi.lkp_negeri';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id_negeri';
    protected $fillable = [
        'negeri',
    ];
}
