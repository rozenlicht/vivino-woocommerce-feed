{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<vivino-product-list>
    @foreach($products as $product)
        @if($product->stock_quantity !== null
        // && $product->attributes->where('name', "Alcoholpercentage")->count() > 0
        && $product->attributes->where('name', "Merk")->count() > 0)
            <product>
                <product-name>{{ $product->producer }} {{ $product->wine_name }} {{ $product->vintage }}</product-name>
                <price>{{ $product->price }}</price>
                <link>{{ $product->permalink }}</link>
                <inventory-count>{{ $product->stock_quantity ?? 0 }}</inventory-count>
                @if($product->alcohol)
                    <alcohol>{{ $product->alcohol }}</alcohol>
                @endif
                <bottles size="750 ml">{{ $product->stock_quantity ?? 0 }}</bottles>
                <extra>
                    <product-id>{{ $product->id }}</product-id>
                    @if($product->vintage)
                        <vintage>{{ $product->vintage }}</vintage>
                    @endif
                    @if($product->attributes->where('name', "Land")->count() > 0)
                        <country>{{ $product->attributes->where('name', "Land")->first()->options[0] }}</country>
                    @endif
                    <appellation>{{ $product->appellation }}</appellation>
                    @if($product->attributes->where('name', "Kleur")->count() > 0)
                        @if($product->attributes->where('name', "Kleur")->first()->options[0] === 'Mousserend')
                            <color>Wit</color>
                        @else
                            <color>{{ $product->attributes->where('name', "Kleur")->first()->options[0] }}</color>
                        @endif
                    @endif
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
        @endif
    @endforeach
</vivino-product-list>
