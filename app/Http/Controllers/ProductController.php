<?php

namespace App\Http\Controllers;

use App\Jobs\ProductStore;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function syncProduct(){

        $shop=Auth::user();
        $products=$shop->api()->rest('GET','/admin/api/2021-07/products.json');
        $product= $products['body']['products'];
        Log::info(count($product));
        for($i=0;$i<count($product);$i++){

            $id= $product[$i]['id'];
            $name= $product[$i]['title'];
            $slug= $product[$i]['handle'];
            $image= $product[$i]['images'][0]['src'];

            $product_id=Product::where('shopify_id',$id)->first();

            if($product_id==null)
            {
               $store = Product::create([
                    'shopify_id' => $id,
                    'product_title' => $name,
                    'handle' => $slug,
                    'image' => $image,
                ]);
//                ProductStore::dispatch($store);
                Log::info('hello');
            }

        }

    }
    public function showProduct(){
        $product=Product::get();

        return $product->toArray();
    }

    public function displayProduct(){

        $shop=Auth::user();
        $products=$shop->api()->rest('GET','/admin/api/2021-07/products.json');
        $product= $products['body']['products'];
        Log::info(count($product));
        return $product->toArray();

    }
//    public function displayGraphProduct(){
//
//        $shop=Auth::user();
//        $query ='{
//                        shop {
//                            name
//                        email
//                        }
//                    }';
//        $products=$shop->api()->graph($query)['body']['data']['shop'];
//        dd($products);
//
//    }
    public function displayProductVariants(Request $request){
        $shop=Auth::user();
//        $query='{
//                  shop {
//                    name
//                    productVariants(first: 10) {
//                      edges {
//                        node {
//                          id
//                          price
//                          sku
//                          displayName
//                          title
//                          image {
//                            src
//                          }
//                        }
//                      }
//                    }
//                  }
//                }';
    Log::info($request);
        if(!empty($request->after)) {
            $params = 'first: 2, after: "'.$request->after.'"';
            Log::info($params);
        }
        else if(!empty($request->before)) {
            $params = 'last: 2, before: "'.$request->before.'"';
            Log::info($params);
        }
        else {
            $params = 'first: 2';
        }
        Log::info($params);
        $query='{
              shop {
                name
                productVariants('.$params.') {
                  edges {
                    node {
                      id
                      price
                      sku
                      displayName
                      title
                      image {
                        src
                      }
                    }
                    cursor
                  }
                  pageInfo {
                    hasNextPage
                    hasPreviousPage
                  }
                }
              }
            }';
//        ['body']['data']['shop']['productVariants']['edges']
        Log::info($params);
            $response=$shop->api()->graph($query);
            Log::info(json_encode($response['body']));
            $productVariant = $response['body']->data->shop->productVariants->edges;
            $next = $response['body']->data->shop->productVariants->pageInfo->hasNextPage;
            $previous = $response['body']->data->shop->productVariants->pageInfo->hasPreviousPage;
//            Log::info(count($productVariant));
            $collections = collect($productVariant);
            $pageInfo=[
                'next'=>$next,
                'previous'=>$previous,
                'after' => $collections->last()['cursor'],
                'before' => $collections[0]['cursor'],
            ];
            return  response(array('productVariant'=>$productVariant,'pageInfo'=>$pageInfo));
    }

    public function updateProductVariantPrice(Request $request){

                Log::info($request);
                $shop=Auth::user();
                $query='mutation mymutation {
                      productVariantUpdate(input: {price: '.$request->price.',id:"'.$request->id.'"}) {
                        userErrors {
                          field
                          message
                        }
                      productVariant{
                        id,
                        price
                      }

                      }
                    }';
                $productVariant=$shop->api()->graph($query)['body']['data']['productVariantUpdate']['productVariant'];
//                dd($productVariant);
                return $productVariant->toArray();
    }



}
