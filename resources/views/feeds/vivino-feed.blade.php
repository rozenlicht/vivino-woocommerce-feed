{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<vivino-product-list>
    @foreach($products as $product)
        <product>
            <product-name>{{ $product->name }}</product-name>
            <price>{{ $product->price }}</price>
            <link>{{ $product->permalink }}</link>
            @if($product->stock_quantity !== null)
                <inventory-count>{{ $product->stock_quantity }}</inventory-count>
            @endif
            <extra>
                <product-id>{{ $product->id }}</product-id>
                @if($product->attributes->where('name', "Land")->count() > 0)
                    <country>{{ $product->attributes->where('name', "Land")->first()->options[0] }}</country>
                @endif
                @if($product->attributes->where('name', "Kleur")->count() > 0)
                    <color>{{ $product->attributes->where('name', "Kleur")->first()->options[0] }}</color>
                @endif
            </extra>
        </product>
    @endforeach
</vivino-product-list>
