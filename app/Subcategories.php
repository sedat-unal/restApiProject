<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    protected $fillable = [
        'sub_name', 'root_catID'
    ];
}
