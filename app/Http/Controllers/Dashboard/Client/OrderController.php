<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Dashboard\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dashboard\Client;
use App\Dashboard\Category;
use App\Dashboard\Product;

class OrderController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        $categories = Category::all();
        return view('dashboard.clients.orders.create', compact('client', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {
        
        $data = $request->validate([
            'product' => 'required|array',
        ]);
        
        $total_price = 0;
        // Create New Order For This Client
        $order = $client->orders()->create([]);

        // Set The Product Ids With Its Quantities In 'order_product' Table For Just Greated Order
        $order->products()->attach( $data['product'] );

        foreach($data['product'] as $id => $quantity){

            // Get The Product, Then Get Quantity Price For It, Then Get The Order Total Price
            $product = Product::FindOrFail($id);
            
            $product_quantity_price = $product->sale_price * $quantity['quantity'];

            $total_price += $product_quantity_price;            

            // Subtract Product Quantity From Its Stock
            $product->update([
                'stock' => $product->stock - $quantity['quantity']                        
            ]);

        }

        // Suffix Total Price With The Order
        $order->update([
            'total_price' => $total_price
        ]);
        
        session()->flash('success', __('site.added_succesfully'));

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order, Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
