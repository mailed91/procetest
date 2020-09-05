<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Groups extends Model
{
    //
    protected $collection = 'groups';
    protected $primaryKey = 'id';
}
