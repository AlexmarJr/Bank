<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\depositTicket;
use App\User;

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
}
