<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Levels extends Model
{
	use SoftDeletes;
    protected $table = 'levels';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'level', 'description', 'thumbnail', 'status', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = [];
}