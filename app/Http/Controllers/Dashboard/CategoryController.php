<?php

namespace App\Http\Controllers\Dashboard;

use App\Dashboard\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Dashboard\CategoryTranslation;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%', app()->getLocale());

        })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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
            $rules[$locale . '.name'] = ['required', 'unique:category_translations,name', 'min:2', 'max:30'];
        }

        $data = $request->validate($rules);

        Category::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.categories.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {

        $rules = [];

        foreach(config('translatable.locales') as $locale){
            $rules[$locale . '.name'] = ['required', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id'), 'min:2', 'max:30'];
        }

        $data = $request->validate($rules);

        $category->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        $category->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.categories.index');
    }
}
