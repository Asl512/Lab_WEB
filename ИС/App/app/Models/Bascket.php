<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bascket extends Model
{
    protected $table = 'bascket';
    protected $fillable = ['fk_id_product'];
}
