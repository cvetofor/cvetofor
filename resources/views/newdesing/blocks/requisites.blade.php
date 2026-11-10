@php
    $legal = \TwillAppSettings::getGroupDataForSectionAndName('legal', 'legal')->content;
@endphp
<div class="section container">
    {{-- Только реквизиты: форма «Связаться с нами» из старого блока
         не переносится — в новом дизайне она есть на «Контактах» --}}
    <section class="page-text page-req" aria-labelledby="page-req-title">
        <h2 id="page-req-title">Реквизиты</h2>
        <dl class="page-req__list">
            @if (! empty($legal['recipient']))
                <div class="page-req__row">
                    <dt>Получатель</dt>
                    <dd>{{ $legal['recipient'] }}</dd>
                </div>
            @endif
            @if (! empty($legal['address']))
                <div class="page-req__row">
                    <dt>Юридический адрес</dt>
                    <dd>{{ $legal['address'] }}</dd>
                </div>
            @endif
            @if (! empty($legal['inn']))
                <div class="page-req__row">
                    <dt>ИНН</dt>
                    <dd>{{ $legal['inn'] }}</dd>
                </div>
            @endif
            @if (! empty($legal['ogrn']))
                <div class="page-req__row">
                    <dt>ОГРНИП</dt>
                    <dd>{{ $legal['ogrn'] }}</dd>
                </div>
            @endif
            @if (! empty($legal['phone']))
                <div class="page-req__row">
                    <dt>Телефон</dt>
                    <dd>{{ $legal['phone'] }}</dd>
                </div>
            @endif
            @if (! empty($legal['email']))
                <div class="page-req__row">
                    <dt>Email</dt>
                    <dd>{{ $legal['email'] }}</dd>
                </div>
            @endif
        </dl>
    </section>
</div>
