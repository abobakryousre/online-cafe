<?php

namespace App\Http\Controllers\api ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Product;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct(){
        $this->middleware("auth:sanctum");
    }

    function index (){
        $products = Product::all();
        $productarr = [] ;
        
        foreach($products as $product){   
            $product->category_id =  $product->category ;
            $productarr[] = $product ;
        }
        return $productarr ;
    }



    public function show(Product $product)
    {
        $product->category_id =  $product->category ;
        return $product;
    }

   
    

    function store(Request $request){
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        $add = Product::create($input);
        if ($add){
            return response()->json(["is_done"=>$request]);
        }else{
            return response()->json(["is_done"=>$request]);

        }
    }


   
    public function update(Request $request, Product $product)
    {
 
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        $update = $product->update($input);   
   
        if ($update){
            return response()->json(["succes"=>$input]);
        }else{
            return response()->json(["error"=>$input]);

        }   
       
    }

   
    public function destroy(Product $product)
    {
      
        $delete = $product->delete();
        if ($delete){
            return response()->json(["is_done"=>true]);
        }else{
            return response()->json(["is_done"=>false]);

        }  
    
    }

    public function available(Request $request, Product $product){
        $update = $product->update($request->all());
        if ($update){
            return response()->json(["message"=>$request]);
        }else{
            return response()->json(["message"=>$request]);

        }   
    }
   
    
}
