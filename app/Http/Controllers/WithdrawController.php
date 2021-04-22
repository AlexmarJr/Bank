<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class WithdrawController extends Controller
{
    public function index_withdraw(){
        return view('withdraw');
    }

    public function withdraw($value){
        $user = User::find(Auth::id());

        if($user->balance < $value){
            return 0;
        }
        else{
            $user->balance = $user->balance - ((int)$value);
            $user->save();
            return 1;
        }
    }
}
