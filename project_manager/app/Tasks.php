<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    //
    protected $table = 'Tasks';
    protected $primaryKey = 'TaskId';
    public function resources(){
    	return $this->hasMany('App\Resources','TaskId','TaskId');
    }
    public function assignments(){
    	return $this->hasMany('App\Assignments','TaskId','TaskId');
    }
}
