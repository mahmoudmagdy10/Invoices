<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['product_name','description','section_id'];

    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

}
