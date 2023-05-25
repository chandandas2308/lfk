<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SalesInvoice;

class Payment extends Model
{
    use HasFactory;

    public function salesInvoice(){
        return $this->hasOne(SalesInvoice::class, 'invoice_no', 'invoice_no');
    }
}
