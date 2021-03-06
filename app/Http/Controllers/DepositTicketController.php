<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\depositTicket;
use Auth;

class DepositTicketController extends Controller
{
    public function index(){
        $data = depositTicket::all();
        return view('deposit', compact('data'));
    }

    public function deposit(Request $request){
        $barcode = rand(1111111111111,9999999999999);
        $check = true;

        while($check == true){
            $c = depositTicket::where('barcode','=', $check)->first();
            if(!empty($c)){
                $barcode = rand(1111111111111,9999999999999);
            }
            else{
                $check = false;
            }
        }
        if($request->ajax())
        {
            depositTicket::create([
                'account' => Auth::user()->account,
                'value_boleto' => (int)$request->value_boleto,
                'barcode' => $barcode,
                'validity' => $request->validity,
            ]);

            return $barcode;

        }
    }
}
