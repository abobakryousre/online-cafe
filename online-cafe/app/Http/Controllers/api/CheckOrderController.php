<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class CheckOrderController extends Controller
{
    function __construct(){
        $this->middleware("auth:sanctum");

    }

    public function index(Request $request)
    {
        $order_id= $request['orderId'];
        
        $order=Order::find($order_id);
        // dd($order);
        $user=$order->user;
        
        $room=Room::find($order->room_id);
        $products=$order->products;

        $data = array("order"=>$order, "user"=>$user , "room"=>$room ,"products"=>$products);
        return response()->json($data);
        
        

    }
    public function update(Request $request)
    {
        $order_id=$request->input('orderId');
        $order=Order::find($order_id);
        $order->status='done';
        $order->save();
        return $order;
        
        

    }


}