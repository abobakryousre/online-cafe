<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


// use Illuminate\Http\Response;
class AdminUserController extends Controller
{
 // list all user by index fun

   public function index(){
       $users = User::all();
       $userArr=[];
        
    foreach($users as $user){   
        $user->rooms =  $user->rooms ;
        $userArr[] = $user ;
    }
       return $userArr;
    //    return response()-> json($users);

   }
    // save users 
    public function store(Request $request)
    {    
            
        $input = $request->all();
        $input['password']=Hash::make($input['password']);

        if ($image = $request->file('avatar')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['avatar'] = "$profileImage";
            }

        $add = User::create($input);

            
        if ($add){
            
            $user = User::find($add->id);
            $rooms = array_map('intval', explode(',', $input['rooms']));

            foreach($rooms as $room)
            {
                
            $user->rooms()->attach($room);
            }
            return response()->json(["is_done"=>true]);
        }else{
            return response()->json(["is_done"=>false]);

        }
        
    }

// delete user
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('user deleted!');
    }

// update user 
public function update($id, Request $request)
    {
        $user = User::find($id);
        $input = $request->all();

        if ($image = $request->file('avatar')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['avatar'] = "$profileImage";
        }
        $update = $user->update($input);   
        
   if ($update){
                 
    $user->rooms()->detach();

      $rooms = array_map('intval', explode(',', $input['rooms']));

    foreach($rooms as $room)
    {

    $user->rooms()->attach($room);
    }
            return response()->json(["succes"=>$input]);
        }else{
            return response()->json(["error"=>$input]);

        }   
        // $url = "";
      
    }




      
// show user with id
public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
     

}
