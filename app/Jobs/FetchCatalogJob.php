<?php

namespace App\Jobs;

use App\Models\Catalog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FetchCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product=$product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $returned_response=Http::get("https://hire.camp/api/catalog")->json();
        $base64_str = str_replace('data: image/png;base64,', '', $returned_response['data']);
        $file = base64_decode($base64_str);
        $name = $this->product->title."".$this->product->catalog_id.".png";
        file_put_contents(public_path().'/images/'.$name, $file);
        $new_catalog=new Catalog();
        $new_catalog->pic_address=$name;
        $new_catalog->product_id=$this->product->id;
        $new_catalog->save();
    }
}
