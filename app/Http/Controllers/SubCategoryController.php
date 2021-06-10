<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\CompanyInfo;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'ENZO | Sub-Category List';

        $company_info = CompanyInfo::all();

        $sub_category_list = SubCategory::join('categories', 'categories.id', '=', 'sub_categories.category_id')
                            ->get(['sub_categories.*', 'categories.name AS category_name']);

        return view('enzo_admin.sub_category_list', compact('title', 'company_info', 'sub_category_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ENZO | Create Sub-Category';

        $company_info = CompanyInfo::all();
        $category_list = Category::where('status', 1)->get();

        return view('enzo_admin.create_sub_category', compact('title', 'company_info', 'category_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'category' => 'required',
            'sub_category_name' => 'required',
            'status' => 'required',
        ]);

        $category = new SubCategory();
        $category->category_id = $request->category;
        $category->sub_category_name = $request->sub_category_name;
        $category->sub_category_description = $request->sub_category_description;
        $category->status = $request->status;
        $category->save();

        \Session::flash('message', "Sub-Category Successfully Created!");

        return redirect()->back();
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
        $title = 'ENZO | Edit Sub-Category';

        $company_info = CompanyInfo::all();
        $category_list = Category::where('status', 1)->get();
        $sub_category = SubCategory::find($id);

        return view('enzo_admin.edit_sub_category', compact('title', 'company_info', 'category_list', 'sub_category'));
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
        $this->validate(request(), [
            'category' => 'required',
            'sub_category_name' => 'required',
            'status' => 'required',
        ]);

        $category = SubCategory::find($id);
        $category->category_id = $request->category;
        $category->sub_category_name = $request->sub_category_name;
        $category->sub_category_description = $request->sub_category_description;
        $category->status = $request->status;
        $category->save();

        \Session::flash('message', "Sub-Category Successfully Updated!");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getSubCategoryListByCatId(Request $request){
        $category = $request->category;

        $sub_category_list = SubCategory::where('category_id', $category)->get();

        return response()->json($sub_category_list, 200);
    }
}
