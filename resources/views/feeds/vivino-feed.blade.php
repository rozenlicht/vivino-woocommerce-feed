{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<vivino-product-list>
    @foreach($products as $product)
        @if($product->wine_name !== null)
            <product>
                <product-name>{{ $product->wine_name }}</product-name>
                <price>{{ $product->price }}</price>
                <link>{{ $product->permalink }}</link>
                <inventory-count>{{ $product->stock_quantity ?? 0 }}</inventory-count>
                @if($product->alcohol)
                    <alcohol>{{ $product->alcohol }}</alcohol>
                @endif
                <bottles size="750 ml">1</bottles>
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
                    @if($product->attributes->where('name', "Bevat melkallergenen")->count() > 0)
                        <contains-milk-allergens>{{ $product->attributes->where('name', "Bevat melkallergenen")->first()->options[0] === 'Ja' ? 'yes' : 'no' }}</contains-milk-allergens>
                    @else
                        <contains-milk-allergens>no</contains-milk-allergens>
                    @endif
                    @if($product->attributes->where('name', "Bevat ei-allergenen")->count() > 0)
                        <contains-egg-allergens>{{ $product->attributes->where('name', "Bevat ei-allergenen")->first()->options[0] === 'Ja' ? 'yes' : 'no' }}</contains-egg-allergens>
                    @else
                        <contains-egg-allergens>no</contains-egg-allergens>
                    @endif
                </extra>
            </product>
        @endif
    @endforeach
</vivino-product-list>
