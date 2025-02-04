<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PLkpAgensi extends Model

{
    protected $table = 'personel.agensi';
    public $timestamps = false;

    protected $primaryKey = 'id';
    protected $fillable = [ //nama column dari database
       'agensi', 'created_at', 'updated_at'

    ];



}
