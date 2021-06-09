<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CompanyInfoController extends Controller
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
        $title = 'ENZO | Company Info';

        $company_info = CompanyInfo::all();

        return view('enzo_admin.company_info', compact('title', 'company_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ENZO | Create Category';

        return view('enzo_admin.create_category', compact('title'));
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
            'name' => 'required|unique:categories',
            'status' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();

        \Session::flash('message', "Category Successfully Created!");

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
        $title = 'ENZO | Edit Company Info';

        $company = CompanyInfo::find($id);

        return view('enzo_admin.edit_company_info', compact('title', 'company'));
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
        $previous_logo_url = $request->previous_logo;
        $file_post = $request->file('file');

        $file_original_name=$previous_logo_url;

        if(isset($file_post)){

            File::delete('storage/uploads/'.$previous_logo_url);

            $file_original_name = $file_post->getClientOriginalName();
            $file_original_extension = $file_post->getClientOriginalExtension();
            $modified_file_name_with_extension = $file_original_name.'.'.$file_original_extension;

            //Move Uploaded File
            $destinationPath = 'storage/uploads';
            $file_post->move($destinationPath,$file_original_name);
        }




        $company = CompanyInfo::find($id);
        $company->company_name = $request->company_name;
        $company->company_description = $request->company_description;
        $company->company_logo = $file_original_name;
        $company->company_email = $request->company_email;
        $company->company_phone = $request->company_phone;
        $company->company_fax = $request->company_fax;
        $company->company_full_address = $request->company_full_address;
        $company->latitude = $request->latitude;
        $company->longitude = $request->longitude;
        $company->save();

        \Session::flash('message', "Company Info Successfully Updated!");

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
}
