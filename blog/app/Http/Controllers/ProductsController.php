<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Auth;
use Session;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error','Under Category is missing');

            }
            $product = new Product;
            $product->category_id= $data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->description=$data['description'];
            $product->price=$data['product_price'];

            //for image
            if($request->hasFile('image')){
                 $image_tmp = $request->file('image'); 
                 if($image_tmp->isValid()){
                     
                    $extension = $image_tmp->getClientoriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path ='img/backend_images/products/large/'.$filename;
                    $medium_image_path ='img/backend_images/products/medium/'.$filename;
                    $small_image_path ='img/backend_images/products/small/'.$filename;

                    //REsize images
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
                    $product->image =$filename;
                 }
                 
            }
            
            $product->save();
            return redirect()->back()->with('flash_message_success','Product has been added successfully');
        }

        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_dropdown .="<option value = '".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProduct(){
        $products = Product::get();
        $products = json_decode(json_encode($products));
       foreach($products as $key => $val){
           $category_name = Category::where(['id'=>$val->category_id])->first();
           $products[$key]->category_name = $category_name->name;

       }
        // echo "<pre>"; print_r($products);die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function editProduct(Request $request, $id = null){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            Product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],
            'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],
            'description'=>$data['description'],'price'=>$data['product_price']]);
            return redirect()->back()->with('flash_message_success','Product has updated successfully');
        }

        $productDetails = Product::where(['id'=>$id])->first();


        $categories = Category::where(['parent_id'=>0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>";
        foreach($categories as $cat){

            if($cat->id == $productDetails->category_id){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id == $productDetails->category_id){
                    $selected = "selected";
                }
                else{
                    $selected = "";
                }

                $categories_dropdown .="<option value = '".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }

        return view('admin.products.edit_products')->with(compact('productDetails','categories_dropdown'));
    }
}
