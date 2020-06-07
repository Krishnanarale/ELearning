<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subjects extends Model
{
	use SoftDeletes;
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'subject', 'level', 'course', 'description', 'thumbnail', 'status', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = [];
}
