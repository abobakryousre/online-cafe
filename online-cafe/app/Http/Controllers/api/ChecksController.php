<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChecksController extends Controller
{
    //

    function __construct(){
        $this->middleware("auth:sanctum");

    }
    
    public function index(Request $request)
    {

        $input = $request->query('selectedUser');
        $start = $request->query('start');
        $end = $request->query('end');
        $data = $this->executeQuery($input, $start, $end);
        $orders = $data['orders'];
        return $orders;
    }

    public function store(Request $request)
    {

        $input = $request->input('selectedUser');
        $start = $request->input('start');
        $end = $request->input('end');
        return $this->executeQuery($input, $start, $end);
    }

    public function getProducts(Request $request)
    {

        $order_id = $request->input('selectedOrderId');
        $order = Order::find($order_id);
        $products = $order->products;

        return $products;
    }

    protected function executeQuery($input, $start, $end)
    {

        $totalAmountForUser = 0;

        $user = User::where('name', $input)->first();
        $id = $user->id;
        $orders = Order::where('user_id', $id)->where('created_at', '>=', $start)->where('created_at', '<=', $end)->paginate(5)->withQueryString();
        foreach ($orders as $order) {
            $totalAmountForUser = $totalAmountForUser + $order->total_price;
        }



        $data = array("user" => $user, "orders" => $orders, "totalAmount" => $totalAmountForUser);
        return $data;
    }
}
