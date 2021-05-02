<?php

namespace App\Http\Controllers;
use App\Jobs\ProcutAddingJob;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $product_list;
    public function retrieveProductList()
    {
        $this->product_list=collect(Http::get("https://hire.camp/api/product")->json('data'));
        $this->createProduct();
    }

    public function createProduct()
    {
        foreach ($this->product_list->chunk(20) as $products_chunked){
            ProcutAddingJob::dispatch($products_chunked)->delay(Carbon::now()->addSeconds(1));
        }
        var_dump("done");
    }

    public function showProductCatalog()
    {
         $products=Product::all();
         return view('products_table',['products'=>$products]);

    }
}
