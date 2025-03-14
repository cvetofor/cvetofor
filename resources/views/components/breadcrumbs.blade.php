<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span class="breadcrumbs__item" itemprop="itemListElement" itemscope
        itemtype="http://schema.org/ListItem">
        <a href="/" itemprop="item">
            <span>Главная</span>
        </a>
        <meta itemprop="position" content="1" />
    </span>
    @foreach ($breadcrumbs as $i => $bread)
        @if (!$loop->last)
            <span class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a href="{{ $prefix ?? '' }}/{{ $bread->nestedSlug }}" itemprop="item">
                    <span itemprop="name">{{ $bread->title }} </span>
                </a>
                <meta itemprop="position" content="{{ $i + 1 }}" />
            </span>
        @else
            <span class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <span itemprop="name">{{ $bread->title }}</span>
                <meta itemprop="position" content="{{ $i + 1 }}" />
            </span>
        @endif
    @endforeach
</div>
