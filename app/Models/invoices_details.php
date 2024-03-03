<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $fillable = [
        'id_Invoice' ,
        'invoice_number',
        'product',
        'Section',
        'Status' ,
        'value_status' ,
        'note' ,
        'user',
        'Payment_Date',
    ];
    use HasFactory;
}
