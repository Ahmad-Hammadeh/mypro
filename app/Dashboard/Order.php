<?php

namespace App\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $guarded = [];

    // Relation With Client Model
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relation With Product Model
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }

    // Attributes Getters And Setters Methods ...

    // Get Total Price By Number Format As Number With Two Decimal Point
    public function getTotalPriceAttribute($value)
    {
        return number_format($value, 2, '.', '');
    }
}
