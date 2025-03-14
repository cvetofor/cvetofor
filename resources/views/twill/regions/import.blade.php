@extends('twill::layouts.free')



@section('customPageContent')

    @if (\Session::has('message'))
        <div class="alert alert-success">
            <ul>
                <li style="margin-bottom:20px;">{!! \Session::get('message') !!}</li>
            </ul>
        </div>
    @endif


    <form action="{{ route('twill.areas.run.import') }}" method="POST">
        @csrf
        <div style="margin-bottom:20px;">
            <h2>Начать импорт городов и регионов</h2>
        </div>
        <a17-button variant="validate" type="submit">Импортировать</a17-button>
    </form>

@stop
