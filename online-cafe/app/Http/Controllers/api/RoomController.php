<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;


class RoomController extends Controller
{
    function __construct(){
        $this->middleware("auth:sanctum");

    }
    
    function index (){
        $room = Room::all();
        return $room ;
    }



    public function show(Room $room)
    {
        return $room;
    }

   
    

    function store(Request $request){

        $add = Room::create($request->all());
        if ($add){
            return response()->json(["message"=>"New Room added successfully"]);
        }else{
            return response()->json(["message"=>"New Room not added successfully"]);

        }
    }


   
    public function update(Request $request, Room $room)
    {
       $update = $room->update($request->all());
        if ($update){
            return response()->json(["message"=>"New room updated successfully"]);
        }else{
            return response()->json(["message"=>"New room not updated successfully"]);

        }   
    }

   
    public function destroy(Room $room)
    {
        $delete = $room->delete();
        if ($delete){
            return response()->json(["message"=>"New room deleted successfully"]);
        }else{
            return response()->json(["message"=>"New room not deleted successfully"]);

        }  
    
    }
}
