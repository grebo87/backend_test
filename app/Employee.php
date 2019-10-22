<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['var_name','var_last_name','var_dni','var_email','var_phone'];
}
