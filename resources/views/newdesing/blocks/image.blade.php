{{-- Первый блок-картинка уходит фоном в баннер страницы (bannerBlockId
     приходит из page.blade.php через renderBlocks) и тут не рендерится --}}
@if (! (($bannerBlockId ?? null) && $block->id === $bannerBlockId))
    <div class="section container">
        <figure class="page-media">
            <img src="{!! $block->image('image', 'desktop') !!}" alt="{{ $block->imageAltText('image') }}" loading="lazy">
            @if ($block->imageCaption('image'))
                <figcaption>{{ $block->imageCaption('image') }}</figcaption>
            @endif
        </figure>
    </div>
@endif
