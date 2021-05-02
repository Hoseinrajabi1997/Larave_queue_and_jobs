<?php

namespace App;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DbTasks
{
    public static function AddtoDb($product)
    {
           $new_product=new Product;
           $new_product->title= $product->title;
           $new_product->catalog_id=$product->catalog_id;
           $new_product->save();
           dd($product);
           return $product;
    }
}
