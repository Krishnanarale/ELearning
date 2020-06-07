<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
	use SoftDeletes;
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'level', 'course', 'description', 'thumbnail', 'rating', 'status', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = [];
}
