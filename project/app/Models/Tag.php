<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'teg';
    protected $fillable = ['id','name'];
}