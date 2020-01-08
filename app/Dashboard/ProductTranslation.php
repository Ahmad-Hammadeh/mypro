<?php

namespace App\Dashboard;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $table = "product_translations";
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
