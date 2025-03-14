<div class="section">
    <div class="container">
        <div class="content">
            <figure><img src="{!! $block->image('image', 'desktop') !!}" alt="{{ $block->imageAltText('image') }}" />
                @if ($block->imageCaption('image'))
                    <figcaption>{{ $block->imageCaption('image') }}</figcaption>
                @endif
            </figure>
        </div>
    </div>
</div>
