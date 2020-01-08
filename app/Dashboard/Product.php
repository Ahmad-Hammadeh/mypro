<?php

namespace App\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // Use Transtable package Trait
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $table = "products";

    protected $guarded = [];

    // Custom Added Property To The Model ...
    protected $appended = ['image_path', 'profit_percent'];



    //Relations With Models ...

    // Relation with category Model
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation With order Model
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }



    // Attributes Getters And Setters Methods ...

    // Get Purchase, Sale Price By Number Format As Number With Two Decimal Point

    public function getPurchasePriceAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }
    
    public function getSalePriceAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }
    
    // Get Image Path
    public function getImagePathAttribute()
    {
        return asset( 'uploads/products/' . $this->image );
    }

    // Get Profit Percent
    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;

        $purchase_price = $this->purchase_price == 0 ? 1: $this->purchase_price;

        $profit_percent = $profit * 100 / $purchase_price;

        return number_format($profit_percent, 2);

    }

}
