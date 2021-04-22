<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class InvestmentsController extends Controller
{
    public function investments_Index(){
        return view("investments");
    }

    public function investments_post($value){
        $user = User::find(Auth::id());

        if($user->balance < $value){
            return 0;
        }
        else{
            $user->balance = $user->balance - $value;
            $user->stocks = $user->stocks + $value;
            $user->save();

            return $value;
        }
    }

    public function withdraw_founds(){
        $user = User::find(Auth::id());

        $user->balance = $user->balance + $user->stocks;
        $user->stocks = 0;
        $user->save();

        return 0;
    }
}
