<?php namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

class ProductsUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(json_encode($this->data));
        Log::info($this->data->id);
        //        Log::info('id'.json_encode($this->data->id));
//        Log::info('title'.json_encode($this->data->title));
//        Log::info('handle'.json_encode($this->data->handle));
//        Log::info('img'.json_encode($this->data->image));

//
        $product=Product::where("shopify_id", $this->data->id)->first();
        $product->product_title =$this->data->title;
        $product->handle = $this->data->handle;
        $product->image = $this->data->image->src;
        $product->save();


//        Log::info(".gfh".$product);
    }
}
