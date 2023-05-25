<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOfPostalDistricts extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_district',
        'postal_sector',
        'general_location',
    ];
}
