<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        "product",
        "section_id",
        "product_id",
        "value_status",
        "status",
        "note",
        "user",
        "pay_date",
        "partial_paied",
        "rest_salary",

    ];
}
