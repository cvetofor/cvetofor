@extends('layouts.app')

@section('content')
<div class="heading heading--big-banner" style="background-image: url('{!! $category->image('cover') !!}');">
    <div class="container">
        <div class="heading__row">
            @include('components.breadcrumbs', [
                'breadcrumbs' => $breadcrumbs,
            ])
            <div class="title-page">
                <h1 class="h1">{{ $category->title }}</h1>
            </div>
        </div>
    </div>
</div>

@include('components.filter')

<div class="section">
    <div class="container">
        <div class="products__wrap">
            @foreach ($products as $product)
              @include('additional_prod_item', ['product'=>$product])
            @endforeach
        </div>
        @if ($category->description)
        <div class="text-page category_description">
            <p>{!! $category->description !!}</p>
        </div>
    @endif
    </div>

</div>
@endsection
