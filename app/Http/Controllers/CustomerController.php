<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::all();
        return $customers->toArray();
    }

    public function store()
    {

        $shop=Auth::user();
        $customers = $shop->api()->rest('GET','/admin/api/2021-10/customers.json');

        $customer = $customers['body']['customers'];
//        for($i=0;$i<count($customer);$i++) {
//            $getCustomer = Customer::find($customer[$i]['id']);
//            if($getCustomer == null)
//            {
//                Customer::create([
//                    'id' => $customer[$i]['id'],
//                    'name' => $customer[$i]['first_name'].''.$customer[$i]['last_name'],
//                    'email' => $customer[$i]['email'],
//                    'address' => $customer[$i]['default_address']['address2'].''.$customer[$i]['default_address']['address1'],
//                ]);
//            }
//        }
        return $customer->toArray();
    }

//    public function graphQl()
//    {
//        $query = "{
//                  shop {
//                    name
//                  }
//                  customers(first: 10) {
//                    edges {
//                      node {
//                        id
//                        firstName
//                        lastName
//                        email
//                        addresses {
//                          address1
//                          address2
//                          zip
//                        }
//                      }
//                    }
//                  }
//                }
//              ";
//
//        $shop=Auth::user();
//        $customers = $shop->api()->graph($query)['body']['container']['data']['customers']['edges'];
//        return $customers;
//    }

    public function graphQl(Request $request)
    {
        $shop=Auth::user();

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
        $query = "{
                  shop {
                    name
                  }
                  customers(".$params.") {
                    edges {
                      node {
                        id
                        firstName
                        lastName
                        email
                        addresses {
                          address2
                          address1
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
              ";

        $data = $shop->api()->graph($query)['body'];
//        Log::info(json_encode($data));
        $customers=$data->data->customers->edges;
        $next = $data->data->customers->pageInfo->hasNextPage;
        $previous = $data->data->customers->pageInfo->hasPreviousPage;

//        dd($customers);
        $collections = collect($customers);

        $pageInfo = [
            'next' => $next,
            'previous' => $previous,
            'after' => $collections->last()['cursor'],
            'before' => $collections[0]['cursor'],
        ];

        return response(array('customers'=>$customers, 'pageInfo'=>$pageInfo));
    }
}
