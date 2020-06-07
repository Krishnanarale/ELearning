<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapters extends Model
{
    use SoftDeletes;
    protected $table = 'chapters';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'level', 'course', 'subject', 'chapter', 'description', 'thumbnail', 'status', 'deleted_at', 'created_at', 'updated_at'];
    protected $hidden = [];
}
