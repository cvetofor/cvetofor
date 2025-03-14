<input class="price_input__field number" @cannot('edit-module', 'products')
    disabled="disabled"
@endcannot required
    data-product-price="" data-id="{{ $price->id }}" value="{{ $price->price }}">

<style>
    .price-changed-sucessful {
        border: 1px solid green !important;
    }

    .price-changed-fail {
        border: 1px solid red !important;
    }

    .price_input__field.number {
        text-indent: 7px;
        max-width: 65px;
        padding: 0;
        margin: 0;
        border: 1px solid #1431345e;
        margin-right: 10px;
        height: 23px;
        line-height: 23px;
    }
</style>
