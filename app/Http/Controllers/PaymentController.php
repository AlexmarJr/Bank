<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\depositTicket;
use App\User;
use Auth;

class PaymentController extends Controller
{
    public function index(){
        return view('payment');
    }

    public function get_boleto($barcode){
        $data = depositTicket::where('barcode', '=', $barcode)->first();
        $data['owner'] = User::where('account', '=', $data->account)->first()->name;
        
        return $data;
    }

    public function payment($id){
        $boleto = depositTicket::find($id);
        if($boleto->value_boleto > Auth::user()->balance){
            return 0;
            
        }elseif(\Carbon\Carbon::now() > $boleto->validity){
            return 1;
        }
        elseif($boleto->status == 1){
            return 2;
        }
        else{
            $user_payer = User::find(Auth::id());
            $user_payer->balance = $user_payer->balance - $boleto->value_boleto;
            $user_payer->save();

            $user_source = User::where('account','=', $boleto->account)->first();
            $user_source->balance = $user_source->balance + $boleto->value_boleto;
            $user_source->save();

            $boleto->status = 1;
            $boleto->save();

            return 3;

        }

    }

    public function add_founds(){
        $user = User::find(Auth::id());
        $user->balance = $user->balance + 100000;
        $user->save();
        return 0;
    }
}
