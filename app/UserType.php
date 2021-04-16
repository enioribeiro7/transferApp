<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    public $timestamps = true;

    
    protected $fillable = [
        'name', 'status','uid'
    ];
}
