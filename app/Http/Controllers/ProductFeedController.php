<?php

namespace App\Http\Controllers;

use Codexshaper\WooCommerce\Models\Product;
use Illuminate\Http\Request;
use App\Services\WoocommerceService;

class ProductFeedController extends Controller
{
    public function vivino()
    {
        $products = collect(\Cache::remember('vivino-products', 60*60, function() {
            $woo = new WooCommerceService();
            return $woo->getByTagSlug('vivino-wijn');
        }))->map(function($product) {
            $product->attributes = collect($product->attributes);
            return $product;
        });
        $view = \View::make('feeds.vivino-feed')->with(compact('products'));
        return response()->make($view, 200)->header('Content-Type', 'application/xml');
    }
}
