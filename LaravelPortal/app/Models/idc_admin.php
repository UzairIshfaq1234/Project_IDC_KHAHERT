<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idc_admin extends Model
{
    protected $fillable = ['Name','Username','Email','Password','Role','Contactno','Image'];

    use HasFactory;
}
