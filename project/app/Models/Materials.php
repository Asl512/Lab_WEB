<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $table = 'material';
    protected $fillable = ['name_material', 'type', 'fk_id_category', 'autors', 'description'];
    protected $primaryKey = 'id_material';
}
