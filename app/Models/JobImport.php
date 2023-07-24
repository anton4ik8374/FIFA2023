<?php

namespace App\Models;

use App\Models\Traites\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobImport extends Model
{
    use HasFactory;
    use Crud;

    protected $fillable = [
        'site',
        'name',
        'slug_league',
        'actual'
    ];
}
