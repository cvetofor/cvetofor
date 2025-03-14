@extends('layouts.app')

@php
    $parent = $item;
    while ($parent = $parent->parent) {
        $breadcrumbs[] = $parent;
    }
@endphp

@section('content')
    @if ($item->image('cover', 'flexible'))
        <div class="heading heading--small-banner">
            <div class="container">
                <div class="heading__row" style="background-image: url({!! $item->image('cover', 'flexible') !!});">
                    @if (isset($breadcrumbs))
                        @include('components.breadcrumbs')
                    @endif
                    <div class="title-page">
                        <h1 class="h1">{{ $item->title }} </h1>
                    </div>

                    @if ($item->description)
                        <div class="text-page">
                            <p> {!! $item->description !!} </p>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    {!! $item->renderBlocks() !!}
@endsection
