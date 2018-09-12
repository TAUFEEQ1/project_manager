<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    protected $primaryKey = 'AssId';
    protected $table = 'Assignments';
	public function workers(){
		return $this->belongsTo('App\Workers','WorkerId','id');
	}
}
