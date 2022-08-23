<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'desc',
        'price',
        'img'
    ];
    public function rate(){
        return $this->hasMany(Rate::class,'product_id');
    }
}
