@extends('twill::layouts.free')



@section('customPageContent')
    <a17-fieldset title="Телефон">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_phone') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Режим работы">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_work_time') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="E-mail">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_email') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Ссылка на договор оферты">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                <a href="{!! TwillAppSettings::get('help-page.help.help_offert-link') !!}" target="_blank" rel="noopener noreferrer">Перейти</a>
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Как это работает">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_how_it-works') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Наши реквизиты">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_our_details') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Претензии и возвраты">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_claims_returns') !!}
            </div>
        </div>

    </a17-fieldset>
    <a17-fieldset title="Дополнительная информация">
        <div class="wrapper">
            <div class="col--double col--double-wrap" style="margin-top:10px;">
                {!! TwillAppSettings::get('help-page.help.help_add_info') !!}
            </div>
        </div>

    </a17-fieldset>

@stop
