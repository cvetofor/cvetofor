@php
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $block->input('url'), $matches);
    $id = isset($matches[1]) ? $matches[1] : '';
@endphp
<div class="section container">
    <figure class="page-media">
        @if ($id)
            {{-- Прямой embed без превью-кнопки старого дизайна: в app.js нет
                 видеомеханики, плеер YouTube грузится сам через loading="lazy" --}}
            <div class="page-media__video">
                <iframe src="https://www.youtube-nocookie.com/embed/{{ $id }}" title="Видео YouTube"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
            </div>
        @endif
        @if ($block->input('description'))
            <figcaption>{{ $block->input('description') }}</figcaption>
        @endif
    </figure>
</div>
