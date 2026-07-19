<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class idc_patient extends Model
{
    protected $fillable = ['Sampleno','Name','Email','Contactno','Addedby','Doctorby','Result','Image','treated'];

    use HasFactory;
}
