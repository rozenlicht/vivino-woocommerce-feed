<?php

namespace App\Services;

use Codexshaper\WooCommerce\Models\Product;
use Codexshaper\WooCommerce\Models\Tag;

class WooCommerceService {

    public function getByTagSlug(string $slug) {
        $tag = Tag::whereSlug($slug)->first();
        $page = 1;
        $all_products = collect([]);
        $products = Product::whereTag($tag['id'])->where('page', $page)->get();
        $count = $products->count();
        $all_products = $all_products->merge($products);
        while($count > 0) {
            $products = Product::whereTag($tag['id'])->where('page', $page)->get();
            $count = $products->count();
            $all_products = $all_products->merge($products);
            $page++;
        }
        return $all_products;
    }
}
