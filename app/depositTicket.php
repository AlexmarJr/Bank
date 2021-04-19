<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class depositTicket extends Model
{
    protected $table = 'deposit_tickets';

    protected $fillable = [
        'account', 'value_boleto', 'barcode','validity',
    ];
}
