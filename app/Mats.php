<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Mats extends Model
{
    //
    protected $collection = 'mats';
    protected $primaryKey = 'id';
}
