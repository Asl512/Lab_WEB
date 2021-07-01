<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $table = 'material';
    protected $fillable = ['id','name','fk_id_type','fk_id_category','autors','description'];
}
