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
        // dd($productarr);
        return $productarr ;
    }



    public function show(Product $product)
    {
        $product->category_id =  $product->category ;
        return $product;
    }

   
    

    function store(Request $request){
       
        // error_log($request->all());
        // $request->validate([
        //     'image' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        //  ]);
 
        //  $fileUpload = new FileUpload;
 
        //  if($request->file()) {
        //      $file_name = time().'_'.$request->file->getClientOriginalName();
        //      $file_path = $request->file('image')->storeAs('uploads', $file_name, 'public');
 
        //      $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
        //      $fileUpload->path = '/storage/' . $file_path;
        //     //  $fileUpload->save();
        //      $request->merge([
        //         'image' => $fileUpload,
        //     ]);
 
        //     //  return response()->json(['success'=>'File uploaded successfully.']);
        //  }

        // $upload_path = public_path('upload');
        // $file_name = $request->file->getClientOriginalName();
        // $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        // $request->file->move($upload_path, $generated_new_name);
         
        // $insert['image'] = $file_name;
        // $check = Product::insertGetId($insert);

        // $request->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
  
        $input = $request->all();
  
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
    
        $add = Product::create($input);
     
        // return redirect()->route('products.index')
        //                 ->with('success','Product created successfully.');
        // $request->merge([
        //             'image' => $file_name,
        //         ]);
        // return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);

        // $add = Product::create($request->all());
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
        // $update = $product->update([
        //     'name' => $input['name'],
        //     'price' => $input['price'],
        //     'image' => $input['image'],
        //     'category_id' => $input['category_id']
        // ]);    
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
        // Page::where('id', $id)->update(array('image' => 'asdasd'));
        $update = $product->update($request->all());
        if ($update){
            return response()->json(["message"=>$request]);
        }else{
            return response()->json(["message"=>$request]);

        }   
    }
   
    
}
