<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalmedico extends Model
{
    use HasFactory;
    protected $table='personal_medico';
    public $timestamp=false;
}
