<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    //
    protected $table = 'Projects';
    protected $primaryKey = 'id';

    public function tasks(){
    	return $this->hasMany('App\Tasks','ProjectId','TasksId');
    }
    public function reports(){
    	return $this->hasMany('App\Reports','ProjectId','id');
    }
}
