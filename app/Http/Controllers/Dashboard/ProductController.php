<?php

namespace App\Http\Controllers\Dashboard;

use App\Dashboard\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dashboard\Category;
use Illuminate\Validation\Rule;
use Storage;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function($q) use ($request)
        {

            return $q->whereTranslationLike('name', '%' . $request->search . '%', app()->getLocale());

        })->when($request->category_id, function($q) use ($request)
        {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale){
            $rules[$locale . '.name'] = ['required', 'unique:product_translations,name', 'min:2', 'max:99'];
            $rules[$locale . '.description'] = ['required', 'min:2', 'max:200'];
        }

        $rules += [ 'category_id' => ['required', Rule::in( Category::pluck('id') )],
                    'image' => 'max:2000|image|mimes:png,jpg,jpeg,gif',
                    'purchase_price' => 'required|',
                    'sale_price' => 'required',
                    'stock' => 'required|integer'
                ];

        $data = $request->validate($rules);

        if( $request->image ){

            // resize the image to a height of 200 and constrain aspect ratio (auto width)
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/' . $request->image->hashName()));

            $data['image'] = $request->image->hashName();

        }

        Product::create($data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact(['product', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [];

        foreach( config('translatable.locales') as $locale ){
            $rules[$locale . '.name'] = ['required', Rule::unique('product_translations', 'name')->ignore($product->id, 'product_id'), 'min:2', 'max:99'];
            $rules[$locale . '.description'] = ['required', 'min:2', 'max:200'];
        }

        $rules += [
            'category_id' => ['required', Rule::in( Category::pluck('id') )],
            'image' => 'max:2000|image|mimes:png,jpg,jpeg,gif',
            'purchase_price' => 'required|',
            'sale_price' => 'required',
            'stock' => 'required|integer'
        ];

        $data = $request->validate($rules);

        if( $request->image ){

            Storage::disk('public_uploads')->delete('/products/' . $product->image);

            // resize the image to a height of 200 and constrain aspect ratio (auto width)
            Image::make($request->image)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path( 'uploads/products/' . $request->image->hashName() ) );

            $data['image'] = $request->image->hashName();

        }

        $product->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if( $product->image ){

            Storage::disk('public_uploads')->delete('/products/' . $product->image);

        }

        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.index');
    }
}
