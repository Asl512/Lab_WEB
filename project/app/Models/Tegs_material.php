<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tegs_material extends Model
{
    protected $table = 'tegs_material';
    protected $fillable = ['id', 'fk_id_teg', 'fk_id_material'];
}
