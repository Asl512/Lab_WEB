<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    protected $table = 'links';
    protected $fillable = ['name_link', 'fk_id_material', 'link'];
    protected $primaryKey = 'id_link';
}
