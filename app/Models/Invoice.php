<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Product;
use App\Models\Invoices_details;
use App\Models\Invoices_attachments;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "invoice_number",
        "invoice_date",
        "due_date",
        "section_id",
        "product_id",
        "amount_collection",
        "amount_commission",
        "discount",
        "value_vat",
        "rate_vat",
        "status",
        "total",
        "value_status",
        "note",
        "user",
        "allocated",
        "partial_paied",
        "rest_salary",

    ];
    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function products(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Invoice_details(){
        return $this->hasMany(Invoices_details::class);
    }
    public function Invoice_attachments(){
        return $this->hasMany(Invoices_attachments::class);
    }

}
