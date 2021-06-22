<?php

namespace App\Http\Controllers;

use App\Category;
use App\CompanyInfo;
use App\ProductColor;
use App\ProductImage;
use App\ProductSize;
use App\ProductSpecification;
use App\ProductStock;
use App\SubCategory;
use Illuminate\Http\Request;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
        $title = 'ENZO | Product List';
        $company_info = CompanyInfo::all();

        $category_list = Category::all();
        $sub_category_list = SubCategory::all();
        $product_list = DB::select("SELECT t1.*, t2.name AS category_name, t3.sub_category_name, t4.total_stock_qty
                    FROM 
                    products AS t1
                    
                    INNER JOIN
                    categories AS t2
                    ON t2.id=t1.category_id
                    
                    INNER JOIN
                    sub_categories AS t3
                    ON t3.id=t1.sub_category_id
                    
                    LEFT JOIN
                    (SELECT product_id, SUM(quantity) AS total_stock_qty 
                    FROM `product_stocks` 
                    WHERE color_id IN (SELECT id FROM product_colors WHERE status=1) 
                    AND size_id IN (SELECT id FROM product_sizes WHERE status=1) 
                    GROUP BY product_id) AS t4
                    ON t4.product_id=t1.id");

        return view('enzo_admin.product_list', compact('title', 'company_info', 'product_list', 'category_list', 'sub_category_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ENZO | Create Product';

        $company_info = CompanyInfo::all();
        $category_list = Category::where('status', 1)->get();
        $sub_category_list = SubCategory::where('status', 1)->get();

        return view('enzo_admin.create_product', compact('title', 'company_info', 'category_list', 'sub_category_list'));
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
            'sub_category' => 'required',
            'product_name' => 'required',
            'status' => 'required',
            'price_in_bdt' => 'required|numeric',
            'price_in_usd' => 'required|numeric',
        ]);

        $datetime_for_file_name = date('YmdHis');

//        Product Info Start
        $category_id = $request->category;
        $sub_category_id = $request->sub_category;
        $product_name = $request->product_name;
        $product_code = $request->product_code;
        $status = $request->status;
        $product_short_description = $request->product_short_description;
        $price_in_bdt = $request->price_in_bdt;
        $price_in_usd = $request->price_in_usd;
        $meta_keywords = $request->meta_keywords;
        $meta_description = $request->meta_description;

        $product = new Product();
        $product->category_id = $category_id;
        $product->sub_category_id = $sub_category_id;
        $product->product_name = $product_name;
        $product->product_code = $product_code;
        $product->product_short_description = $product_short_description;
        $product->price_in_bdt = $price_in_bdt;
        $product->price_in_usd = $price_in_usd;
        $product->meta_keywords = $meta_keywords;
        $product->meta_description = $meta_description;
        $product->status = $status;
        $product->save();

        $product_id = $product->id;
//        Product Info End

//        Color-Image Start
        $color_names = $request->color_name;
        $color_codes = $request->color_code;

        if(sizeof($color_names) > 0){
            foreach ($color_names as $k_c => $color){

                $product_color = new ProductColor();
                $product_color->product_id = $product_id;
                $product_color->color = $color;
                $product_color->color_code = $color_codes[$k_c];
                $product_color->status = 1;
                $product_color->save();

                $product_color_id = $product_color->id;

                $file_post = $request->file('file_'.$k_c);

                $total_count = count($file_post);

                for( $i=0 ; $i < $total_count ; $i++ ) {
                    $file_original_name = $file_post[$i]->getClientOriginalName();
                    $file_original_extension = $file_post[$i]->getClientOriginalExtension();
                    $modified_file_name_with_extension = $product_id.'_'.$k_c.'_'.$i.'_'.$datetime_for_file_name.'.'.$file_original_extension;

                    //Move Uploaded File
                    $destinationPath = 'storage/uploads';
                    $file_post[$i]->move($destinationPath,$modified_file_name_with_extension);

                    $product_image = new ProductImage();
                    $product_image->product_id = $product_id;
                    $product_image->color_id = $product_color_id;
                    $product_image->image_url = $modified_file_name_with_extension;
                    $product_image->save();

                }

            }
        }
//        Color-Image End

//        Size Start
        $sizes = $request->sizes;
        $size_descriptions = $request->size_descriptions;

        if(sizeof($sizes) > 0){
            foreach($sizes as $k_sz => $size){

                $product_size = new ProductSize();
                $product_size->product_id = $product_id;
                $product_size->size = $size;
                $product_size->size_description = $size_descriptions[$k_sz];
                $product_size->status = 1;
                $product_size->save();

            }
        }
//        Size End

//        Specifications Start
        $specification_names = $request->specification_name;
        $specification_descriptions = $request->specification_description;

        if(sizeof($specification_names) > 0){
            foreach($specification_names as $k_spc => $specification_name){

                $product_specification = new ProductSpecification();
                $product_specification->product_id = $product_id;
                $product_specification->specification_name = $specification_name;
                $product_specification->specification_description = $specification_descriptions[$k_spc];
                $product_specification->status = 1;
                $product_specification->save();

            }
        }
//        Specifications End

        \Session::flash('message', "Product Successfully Created!");

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
        $title = 'ENZO | Edit Product';

        $company_info = CompanyInfo::all();
        $category_list = Category::where('status', 1)->get();
        $sub_category_list = SubCategory::where('status', 1)->get();

        $product = Product::find($id);
        $product_colors = ProductColor::where('product_id', $id)->get();
        $product_sizes = ProductSize::where('product_id', $id)->get();
        $product_specifications = ProductSpecification::where('product_id', $id)->get();

        return view('enzo_admin.edit_product', compact('title', 'company_info', 'category_list', 'sub_category_list', 'product', 'product_colors', 'product_sizes', 'product_specifications'));
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
            'sub_category' => 'required',
            'product_name' => 'required',
            'status' => 'required',
            'price_in_bdt' => 'required|numeric',
            'price_in_usd' => 'required|numeric',
        ]);

        $datetime_for_file_name = date('YmdHis');

        $category_id = $request->category;
        $sub_category_id = $request->sub_category;
        $product_name = $request->product_name;
        $product_code = $request->product_code;
        $status = $request->status;
        $product_short_description = $request->product_short_description;
        $price_in_bdt = $request->price_in_bdt;
        $price_in_usd = $request->price_in_usd;
        $meta_keywords = $request->meta_keywords;
        $meta_description = $request->meta_description;

        $product = Product::find($id);
        $product->category_id = $category_id;
        $product->sub_category_id = $sub_category_id;
        $product->product_name = $product_name;
        $product->product_code = $product_code;
        $product->product_short_description = $product_short_description;
        $product->price_in_bdt = $price_in_bdt;
        $product->price_in_usd = $price_in_usd;
        $product->meta_keywords = $meta_keywords;
        $product->meta_description = $meta_description;
        $product->status = $status;
        $product->save();


//        Color-Image Old Start
        $color_ids = $request->color_ids;
        $color_names = $request->color_name_old;
        $color_codes = $request->color_code_old;
        $old_colors_status = $request->old_colors_status;


        if(sizeof($color_ids) > 0){
            foreach ($color_ids as $k_cid => $color_id){

                $product_color = ProductColor::find($color_id);
                $product_color->product_id = $id;
                $product_color->color = $color_names[$k_cid];
                $product_color->color_code = $color_codes[$k_cid];
                $product_color->status = $old_colors_status[$k_cid];
                $product_color->save();

                $file_old_post = $request->file('file_old_'.$k_cid);

                if(isset($file_old_post)){
                    $total_count = count($file_old_post);

                    for( $i=0 ; $i < $total_count ; $i++ ) {
                        $file_original_name = $file_old_post[$i]->getClientOriginalName();
                        $file_original_extension_new_addition = $file_old_post[$i]->getClientOriginalExtension();
                        $modified_file_name_with_extension_new_addition = $id.'_'.$k_cid.'_'.$i.'_'.$datetime_for_file_name.'.'.$file_original_extension_new_addition;

                        //Move Uploaded File
                        $destinationPath_old = 'storage/uploads';
                        $file_old_post[$i]->move($destinationPath_old,$modified_file_name_with_extension_new_addition);

                        $product_image_old = new ProductImage();
                        $product_image_old->product_id = $id;
                        $product_image_old->color_id = $color_id;
                        $product_image_old->image_url = $modified_file_name_with_extension_new_addition;
                        $product_image_old->save();
                    }
                }
            }
        }
//        Color-Image Old End


//        Color-Image New Start
        $color_names = $request->color_name;
        $color_codes = $request->color_code;

        if(isset($color_names)){
            if(sizeof($color_names) > 0){
                foreach ($color_names as $k_c => $color){

                    $product_color = new ProductColor();
                    $product_color->product_id = $id;
                    $product_color->color = $color;
                    $product_color->color_code = $color_codes[$k_c];
                    $product_color->status = 1;
                    $product_color->save();

                    $product_color_id = $product_color->id;

                    $file_post = $request->file('file_'.$k_c);

                    $total_count = count($file_post);

                    for( $i=0 ; $i < $total_count ; $i++ ) {
                        $file_original_name = $file_post[$i]->getClientOriginalName();
                        $file_original_extension = $file_post[$i]->getClientOriginalExtension();
                        $modified_file_name_with_extension = $id.'_'.$k_c.'_'.$i.'_'.$datetime_for_file_name.'.'.$file_original_extension;

                        //Move Uploaded File
                        $destinationPath = 'storage/uploads';
                        $file_post[$i]->move($destinationPath,$modified_file_name_with_extension);

                        $product_image = new ProductImage();
                        $product_image->product_id = $id;
                        $product_image->color_id = $product_color_id;
                        $product_image->image_url = $modified_file_name_with_extension;
                        $product_image->save();

                    }

                }
            }
        }

//        Color-Image New End

//        Size Old Start
        $size_ids = $request->size_ids;
        $sizes_old = $request->sizes_old;
        $size_descriptions_old = $request->size_descriptions_old;
        $old_sizes_status = $request->old_sizes_status;

        if(sizeof($size_ids) > 0){
            foreach($size_ids as $k_szid => $size_id){

                $product_size_old = ProductSize::find($size_id);
                $product_size_old->product_id = $id;
                $product_size_old->size = $sizes_old[$k_szid];
                $product_size_old->size_description = $size_descriptions_old[$k_szid];
                $product_size_old->status = $old_sizes_status[$k_szid];
                $product_size_old->save();

            }
        }
//        Size Old End


//        Size New Start
        $sizes = $request->sizes;
        $size_descriptions = $request->size_descriptions;

        if(isset($sizes)){
            if(sizeof($sizes) > 0){
                foreach($sizes as $k_sz => $size){

                    $product_size = new ProductSize();
                    $product_size->product_id = $id;
                    $product_size->size = $size;
                    $product_size->size_description = $size_descriptions[$k_sz];
                    $product_size->status = 1;
                    $product_size->save();

                }
            }
        }
//        Size New End

//        Specifications Old Start
        $specification_id_olds = $request->specification_id_old;
        $specification_name_old = $request->specification_name_old;
        $specification_description_old = $request->specification_description_old;
        $old_specifications_status = $request->old_specifications_status;

        if(sizeof($specification_id_olds) > 0){
            foreach($specification_id_olds as $k_spc_id => $specification_id_old){

                $product_specification_old = ProductSpecification::find($specification_id_old);
                $product_specification_old->product_id = $id;
                $product_specification_old->specification_name = $specification_name_old[$k_spc_id];
                $product_specification_old->specification_description = $specification_description_old[$k_spc_id];
                $product_specification_old->status = $old_specifications_status[$k_spc_id];
                $product_specification_old->save();

            }
        }
//        Specifications Old End


//        Specifications New Start
        $specification_names = $request->specification_name;
        $specification_descriptions = $request->specification_description;

        if(isset($specification_names)){
            if(sizeof($specification_names) > 0){
                foreach($specification_names as $k_spc => $specification_name){

                    $product_specification = new ProductSpecification();
                    $product_specification->product_id = $id;
                    $product_specification->specification_name = $specification_name;
                    $product_specification->specification_description = $specification_descriptions[$k_spc];
                    $product_specification->status = 1;
                    $product_specification->save();

                }
            }
        }
//        Specifications New End

        \Session::flash('message', "Product Successfully Updated!");

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

    public function getExistingImages(Request $request){
        $product_id = $request->product_id;
        $color_id = $request->color_id;

        $product_images = ProductImage::where('product_id', $product_id)
                                        ->where('color_id', $color_id)
                                        ->get();

        return response()->json($product_images, 200);
    }

    public function deleteExistingImage(Request $request){
        $image_id = $request->image_id;
        $image_url = $request->image_url;

        $product_image = ProductImage::find($image_id);
        $product_image_url = $product_image->image_url;

        ProductImage::destroy($image_id);

        File::delete('storage/uploads/'.$product_image_url);

        return response()->json('success', 200);
    }

    public function productStockManagement($id){
        $title = 'ENZO | Product Stock';

        $company_info = CompanyInfo::all();
        $product = Product::find($id);
        $product_colors = ProductColor::where('product_id', $id)->where('status', 1)->get();
        $product_sizes = ProductSize::where('product_id', $id)->where('status', 1)->get();
        $product_stocks = ProductStock::join('product_colors', 'product_colors.id', '=', 'product_stocks.color_id')
                            ->join('product_sizes', 'product_sizes.id', '=', 'product_stocks.size_id')
                            ->where('product_stocks.product_id', $id)
                            ->where('product_sizes.status', 1)
                            ->where('product_colors.status', 1)
                            ->get(['product_stocks.*', 'product_colors.color', 'product_colors.status as color_status',
                                'product_sizes.size', 'product_sizes.status as size_status', 'product_sizes.size_description']);

        return view('enzo_admin.product_stock_list', compact('title', 'company_info', 'product', 'product_colors', 'product_sizes', 'product_stocks'));
    }

    public function saveNewColorSizeCombination(Request $request){
        $product_id = $request->product_id;
        $color_id = $request->color_id;
        $size_id = $request->size_id;

        $product_stock_info = ProductStock::where('product_id', $product_id)->where('color_id', $color_id)->where('size_id', $size_id)->get();

        if(sizeof($product_stock_info) == 0){

            $product_stock = new ProductStock();
            $product_stock->product_id = $product_id;
            $product_stock->color_id = $color_id;
            $product_stock->size_id = $size_id;
            $product_stock->quantity = 0;
            $product_stock->save();
        }

        return response()->json($product_stock_info, 200);
    }

    public function updateProductStock(Request $request){

        $product_stock_ids = $request->product_stock_id;
        $product_stock_quantitys = $request->product_stock_quantity;

        if(isset($product_stock_ids) > 0){
            foreach($product_stock_ids as $k => $product_stock_id){

                $product_stock = ProductStock::find($product_stock_id);
                $product_stock->quantity = $product_stock_quantitys[$k];
                $product_stock->save();

            }
        }

        \Session::flash('message', "Product Stock Successfully Updated!");

        return redirect()->back();
    }

    public function filterProduct(Request $request){
        $product = $request->product;
        $category = $request->category;
        $sub_category = $request->sub_category;

        $where = '';

        if(!empty($product)){
            $where .= " AND t1.id=$product";
        }

        if(!empty($category)){
            $where .= " AND t1.category_id=$category";
        }

        if(!empty($sub_category)){
            $where .= " AND t1.sub_category_id=$sub_category";
        }

        $product_list = DB::select("SELECT t1.*, t2.name AS category_name, t3.sub_category_name, t4.total_stock_qty
                    FROM 
                    products AS t1
                    
                    INNER JOIN
                    categories AS t2
                    ON t2.id=t1.category_id
                    
                    INNER JOIN
                    sub_categories AS t3
                    ON t3.id=t1.sub_category_id
                    
                    LEFT JOIN
                    (SELECT product_id, SUM(quantity) AS total_stock_qty 
                    FROM `product_stocks` 
                    WHERE color_id IN (SELECT id FROM product_colors WHERE status=1) 
                    AND size_id IN (SELECT id FROM product_sizes WHERE status=1) 
                    GROUP BY product_id) AS t4
                    ON t4.product_id=t1.id
                    
                    WHERE 1 $where");

        $new_line = '';

        foreach($product_list as $product){
            $new_line .= "<tr>";
            $new_line .= '<td class="text-center">'.$product->id.'</td>';
            $new_line .= '<td class="text-center">'.$product->category_name.'</td>';
            $new_line .= '<td class="text-center">'.$product->sub_category_name.'</td>';
            $new_line .= '<td class="text-center">'.$product->product_name.'</td>';
            $new_line .= '<td class="text-center">'.$product->price_in_bdt.'</td>';
            $new_line .= '<td class="text-center">'.$product->price_in_usd.'</td>';
            $new_line .= '<td class="text-center">'.($product->total_stock_qty != '' ? $product->total_stock_qty : 0).'</td>';
            $new_line .= '<td class="text-center">'.($product->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>').'</td>';
            $new_line .= '<td class="text-center"><a class="btn btn-info btn-xs" href="'.route('product.edit', $product->id).'" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fas fa-pencil-alt"></i></a><a class="btn btn-secondary btn-xs ml-1" href="'.route('product_stock_management', $product->id).'" title="Stock" data-toggle="tooltip" data-placement="top"><i class="fas fa-warehouse"></i></a></td>';
            $new_line .= "</tr>";
        }

        return $new_line;
    }
}
