<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
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
        $locations = Location::all();
        return  view('admin.subcategory.create', compact('locations'));
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
        $subcat->location_id = $request->location_id;
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        $locations = Location::all();
        return view('admin.subcategory.edit', compact('subcategory', 'locations'));
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
        $subcat = SubCategory::find($id);
        $subcat->name = $request->name;
        $subcat->location_id = $request->location_id;
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
