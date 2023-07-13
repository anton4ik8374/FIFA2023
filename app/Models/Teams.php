<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'id',
        'name_en',
        'name_ru',
        'alter_name',
        'description'
    ];}
