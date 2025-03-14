@php
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $block->input('url'), $matches);
    $id = isset($matches[1]) ? $matches[1] : '';
@endphp
<div class="section">
    <div class="container">
        <div class="content">
            <figure>
                <div class="video video--overlay" data-video-wrap="data-video-wrap">
                    <img src="https://img.youtube.com/vi/{{ $id }}/0.jpg" alt="" data-video-preview="data-video-preview" />
                    <iframe width="560" height="315" src="{{ $block->input('url') }}" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""
                        data-video="data-video"></iframe>
                    <button class="play-button" data-video-play="data-video-play">
                        <svg>
                            <use href="#icon-play"></use>
                        </svg>
                    </button>
                </div>

                @if ($block->input('description'))
                    <figcaption>{{ $block->input('description') }}</figcaption>
                @endif
            </figure>
        </div>
    </div>
</div>
