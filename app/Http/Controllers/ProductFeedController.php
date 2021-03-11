<?php

namespace App\Http\Controllers;

use Codexshaper\WooCommerce\Models\Product;
use Illuminate\Http\Request;
use App\Services\WooCommerceService;
use Illuminate\Support\Str;

class ProductFeedController extends Controller
{
    public function vivino()
    {
        $no_vintage = [];
        $products = collect(\Cache::remember('vivino-products', 60*60, function() {
            $woo = new WooCommerceService();
            return $woo->getByTagSlug('vivino-wijn');
        }))->map(function($product) {
            $product->attributes = collect($product->attributes);
            $matches = [];
            $product->producer = null;
            $product->wine_name = null;
            $product->vintage = null;
            $product->alcohol = null;
            $product->appellation = null;
            preg_match('/\b(19|20)\d{2}\b/', $product->name, $matches);
            if((count($matches) > 0 || Str::contains($product->name, ' NV'))
                && $product->attributes->where('name', "Vivino naam")->count() > 0
                && $product->attributes->where('name', "Streek")->count() > 0
            ) {
                if($product->attributes->where('name', "Alcoholpercentage")->count() > 0) {
                    $product->alcohol = $product->attributes->where('name', "Alcoholpercentage")->first()->options[0];
                }
                $product->vintage = count($matches) > 0 ? $matches[0] : 'NV';
                if($product->attributes->where('name', "Producent")->count() > 0) {
                    $product->producer = $product->attributes->where('name', "Producent")->first()->options[0];
                }
                $product->wine_name = ucwords($product->attributes->where('name', "Vivino naam")->first()->options[0]);
                $product->appellation = ucwords($product->attributes->where('name', "Streek")->first()->options[0]);
            } else {
                $no_vintage[] = $product;
            }
            return $product;
        });
        dd($no_vintage);
        $view = \View::make('feeds.vivino-feed')->with(compact('products'));
        return response()->make($view, 200)->header('Content-Type', 'application/xml');
    }

    public function removeFromString($needle, $haystack) {
        return trim(str_ireplace($needle, '', $haystack));
    }
}
