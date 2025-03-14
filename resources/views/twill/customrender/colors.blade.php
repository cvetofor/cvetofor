<ul style="display: flex; align-items:center; flex-direction: row;   flex-wrap: wrap; min-width: 150px;">
    @foreach ($skus as $sku)
        @php
            $color = $sku->colors()->first();
        @endphp

        @if ($color)
            <li @can('edit-module', 'products')
                    onclick="changeStatusColor({{ $sku->id }}, this)"
                else
                    disabled="disabled"
                @endcan
                style="background:{{ optional($color->data)['rgb'] ?? '' }};margin: 2px;"
                class="product-color  @if (!$sku->published) product-color_stayout @endif"
                title="{{ $color->title }}">
                @if ($sku->published)
                    ✓
                    @endif @if (!optional($color->data)['rgb'] ?? '')
                        {{ $color->title }}
                    @endif
            </li>
        @endif
    @endforeach
</ul>


{{-- {{ js в папке resources/views/twill/products/create.blade.php }} --}}

<style>
    .product-color {
        margin-right: 10px;
        min-width: 20px;
        min-height: 20px;
        border-radius: 20px;
        text-align: center;
        color: darkslategrey;
        min-width: 20px;
        min-height: 20px;
        max-width: 20px;
        max-height: 20px;

        @can('edit-module', 'products')
            cursor: pointer;
        @endcan
    }

    .product-color_stayout {
        opacity: 0.7;
    }
</style>
