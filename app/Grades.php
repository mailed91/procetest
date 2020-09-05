<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Grades extends Model
{
    //
    protected $collection = 'grades';
    protected $primaryKey = 'id';
}
