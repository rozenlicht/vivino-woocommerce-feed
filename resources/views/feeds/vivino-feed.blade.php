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
                @if($product->vintage)
                    <vintage>{{ $product->vintage }}</vintage>
                @endif
                @if($product->attributes->where('name', "Land")->count() > 0)
                    <country>{{ $product->attributes->where('name', "Land")->first()->options[0] }}</country>
                @endif
                @if($product->attributes->where('name', "Alcoholpercentage")->count() > 0)
                    <alcohol>{{ $product->attributes->where('name', "Alcoholpercentage")->first()->options[0] }}</alcohol>
                @endif
                @if($product->attributes->where('name', "Kleur")->count() > 0)
                    <color>{{ $product->attributes->where('name', "Kleur")->first()->options[0] }}</color>
                @endif
                <importer-address>{{ config('woocommerce.importer_address') }}</importer-address>
                <contains-added-sulfites>yes</contains-added-sulfites>
                <contains-milk-allergens>
                    @if($product->attributes->where('name', "Bevat melkallergenen")->count() > 0)
                        {{ $product->attributes->where('name', "Bevat melkallergenen")->first()->options[0] === 'Ja' ? 'yes' : 'no' }}
                    @else
                        no
                    @endif
                </contains-milk-allergens>
                <contains-egg-allergens>
                    @if($product->attributes->where('name', "Bevat ei-allergenen")->count() > 0)
                        {{ $product->attributes->where('name', "Bevat ei-allergenen")->first()->options[0] === 'Ja' ? 'yes' : 'no' }}
                    @else
                        no
                    @endif
                </contains-egg-allergens>
            </extra>
        </product>
    @endforeach
</vivino-product-list>
