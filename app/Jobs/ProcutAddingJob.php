<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProcutAddingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $products;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products=$products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->products as $product){
            $new_product=new Product;
            $new_product->title=$product['title'];
            $new_product->catalog_id=$product['catalog_id'];
            $new_product->save();
            FetchCatalogJob::dispatch($new_product)->delay(Carbon::now()->addSeconds(1));
        }
    }
}
