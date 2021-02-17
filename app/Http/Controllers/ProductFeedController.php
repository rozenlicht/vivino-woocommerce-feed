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
        $products = collect(\Cache::remember('vivino-products', 60*60, function() {
            $woo = new WooCommerceService();
            return $woo->getByTagSlug('vivino-wijn');
        }))->map(function($product) {
            $product->attributes = collect($product->attributes);
            $matches = [];
            preg_match('/\b(19|20)\d{2}\b/', $product->name, $matches);
            if(count($matches) > 0
                && $product->attributes->where('name', "Streek")->count() > 0
                && $product->attributes->where('name', "Merk")->count() > 0
            ) {
                $product->vintage = $matches[0];
                $product->producer = $product->attributes->where('name', "Merk")->first()->options[0];
                $product->appellation = ucwords($product->attributes->where('name', "Streek")->first()->options[0]);
                $product->wine_name = $this->removeFromString($product->vintage, $product->name);
                $product->wine_name = $this->removeFromString($product->appellation, $product->wine_name);
                foreach($product->attributes->where('name', "Land") as $land) {
                    $product->wine_name = $this->removeFromString($land->options[0], $product->wine_name);
                }
                foreach($product->attributes->where('name', "Streek") as $land) {
                    $product->wine_name = $this->removeFromString($land->options[0], $product->wine_name);
                }
                foreach($product->attributes->where('name', "Merk") as $land) {
                    $product->wine_name = $this->removeFromString($land->options[0], $product->wine_name);
                }
            } else {
                $product->vintage = null;
            }
            return $product;
        });
        $view = \View::make('feeds.vivino-feed')->with(compact('products'));
        return response()->make($view, 200)->header('Content-Type', 'application/xml');
    }

    public function removeFromString($needle, $haystack) {
        return trim(str_replace($needle, '', $haystack));
    }
}
