<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class ProfileController extends Controller
{
    public function index(){
        return view('profile');
    }

    public function get_pix(){
        return Auth::user()->pix;
    }

    public function save_pix(Request $request){
        if($request->ajax()){
            if($request->type == 'random'){
                $request->key = strval(rand(11111111,999999999));
            }
            $user = User::find(Auth::id());
            $user_pix = json_decode($user->pix);
            $pix_array = array();

            if(!empty($user_pix)){
                foreach($user_pix as $key=>$value){
                    if($request->principal == 1){
                        array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => 0]);
                    }
                    else{
                        array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => $value->principal]);
                    }
                }
            }
           
            array_push($pix_array, ["key" => $request->key, "type" => $request->type, "principal" => $request->principal]);
            $user->pix = json_encode($pix_array);
            $user->save();
        }

    }

    public function change_principal($id){
            $user = User::find(Auth::id());
            $user_pix = json_decode($user->pix);
            $pix_array = array();

                foreach($user_pix as $key=>$value){
                    if($value->principal == 1){
                        array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => 0]);
                    }
                    elseif($value->key == $id){
                        array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => 1]);
                    }
                    else{
                        array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => $value->principal]);
                    }
                }
           
            $user->pix = array(['']);
            $user->pix = json_encode($pix_array);
            $user->save();

            return 'true';
    }

    public function delete_pix($id){
        $user = User::find(Auth::id());
        $user_pix = json_decode($user->pix);
        $pix_array = array();

            foreach($user_pix as $key=>$value){
                if($value->key == $id){
                    
                }
                else{
                    array_push($pix_array, ["key" => $value->key, "type" => $value->type, "principal" => $value->principal]);
                }
            }
       
        $user->pix = array(['']);
        $user->pix = json_encode($pix_array);
        $user->save();

        return 'true';
    }
}
