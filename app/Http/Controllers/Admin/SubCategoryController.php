<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcateg = SubCategory::all();
        return view('admin.subcategory.index', compact('subcateg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('is_vip', 'Oui')->get();
        return  view('admin.subcategory.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcat = new SubCategory();
        $subcat->name = $request->name;
        $subcat->category_id = $request->category_id;
        if ($request->hasfile('image')) {
            $image1 = $request->file('image');
            $name = time() . 'category' . '.' . $image1->getClientOriginalExtension();
            $destinationPath = 'category/';
            $image1->move($destinationPath, $name);
            $subcat->image = 'category/' . $name;
        }
        $subcat->save();
        return redirect(route('admin.souscategorie.index'))->withSuccess('The Data Inserted Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = SubCategory::find($id);
        $cat->delete();
        return redirect(route('admin.souscategorie.index'))->withSuccess('The Deleted Successfully');

    }
}
