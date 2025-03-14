@extends('layouts.app')

@section('content')
<div class="heading heading--big-banner" style="background-image: url('{!! $category->image('cover') !!}');">
    <div class="container">
        <div class="heading__row">
            @include('components.breadcrumbs', ['prefix' => '/catalog'])
            <div class="title-page">
                <h1 class="h1">{{ $category->title }}</h1>
            </div>
        </div>
    </div>
</div>

@include('components.filter')

@foreach ($prices as $paginator)
@if ($paginator->items())
<div class="section">
    <div class="container">
        @include('components.category', ['paginator' => $paginator])
        <div class="text-page category_description">
            <p>{!! $category->description !!}</p>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection