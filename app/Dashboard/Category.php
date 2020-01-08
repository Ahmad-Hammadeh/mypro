<?php

namespace App\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Use Transtable package Trait
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];

    protected $table = "categories";

    protected $guarded = [];

    // Relation with Product Model
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
