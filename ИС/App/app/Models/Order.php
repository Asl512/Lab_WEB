<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['name_order','fk_id_product','count','fk_id_shop','fk_id_staff','status'];
}
