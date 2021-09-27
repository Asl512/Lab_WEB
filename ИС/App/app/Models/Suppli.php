<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Suppli extends Model
{
    protected $table = 'suppli';
    protected $fillable = ['name_suppli','fk_id_product','count','fk_id_supplier'];
}
