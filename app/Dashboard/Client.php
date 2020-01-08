<?php

namespace App\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';

    protected $fillable = ['name', 'phone', 'address'];

    protected $casts = [
        'phone' => 'array'
    ];

    // Relation With Order Model
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Attributes Getters And Setters Methods ...

    // Get Name Attribute With Capitalize First Letter
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

}
