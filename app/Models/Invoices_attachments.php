<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_attachments extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'invoice_number',
        'invoice_id',
        "created_by",
    ];
}
