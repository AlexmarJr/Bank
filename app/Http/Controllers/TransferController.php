<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;

class TransferController extends Controller
{
    public function index(){
        return view('transfer');
    }

    public function pix_get($type, $key){
        $data = DB::table('users')
                ->whereJsonContains('pix', ['key' => $key])
                ->whereJsonContains('pix', ['type' => $type])
                ->get();

                if($data->isEmpty()){
                    return 0;
                }
        return $data;
    }

    public function post_pix(Request $request){
        if($request->ajax()){
             $user_receive = User::find($request->id);
            $user_transfer = User::find(Auth::id());

            if($user_transfer->balance < (int)$request->pix_value){
                return 1;
            }
            $user_receive->balance = $user_receive->balance + ((int)$request->pix_value);
            $user_receive->save();
            $user_transfer->balance = $user_transfer->balance - ((int)$request->pix_value);
            $user_transfer->save();

            return 'success';
        }
    }
}
