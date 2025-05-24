<?php

namespace A17\Twill\Models;

use A17\Twill\Facades\TwillUtil;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPresenter;
use A17\Twill\Models\Behaviors\HasRelated;
use A17\Twill\Models\Contracts\TwillModelContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Block extends BaseModel implements TwillModelContract
{
    use HasFiles;
    use HasMedias;
    use HasPresenter;
    use HasRelated;
    use QueryCacheable;

    /**
     * Invalidate the cache automatically
     * upon update in the database.
     *
     * @var bool
     */
    protected static $flushCacheOnUpdate = true;

    /**
     * Specify the amount of time to cache queries.
     * Do not specify or set it to null to disable caching.
     *
     * @var int|\DateTime
     */
    public $cacheFor = 3600;

    /**
     * The tags for the query cache. Can be useful
     * if flushing cache for specific tags only.
     *
     * @var null|array
     */
    public $cacheTags = ['blocks'];

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @var string
     */
    public $cachePrefix = 'blocks_';

    public $timestamps = false;

    protected $fillable = [
        'blockable_id',
        'blockable_type',
        'position',
        'content',
        'type',
        'child_key',
        'parent_id',
        'editor_name',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $with = ['medias', 'children'];

    public function scopeEditor($query, $name = 'default')
    {
        return $name === 'default' ?
            $query->where('editor_name', $name)->orWhereNull('editor_name') :
            $query->where('editor_name', $name);
    }

    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }

    public function children(): HasMany
    {
        return $this->hasMany(twillModel('block'), 'parent_id')
            ->orderBy(
                $this->getTable().'.position',
                'asc'
            );
    }

    public function wysiwyg(string $name): string
    {
        return TwillUtil::parseInternalLinks($this->input($name) ?? '');
    }

    public function translatedWysiwyg(string $name): string
    {
        return TwillUtil::parseInternalLinks($this->translatedInput($name) ?? '');
    }

    public function input(string $name): mixed
    {
        return $this->content[$name] ?? null;
    }

    public function translatedInput(string $name, ?bool $forceLocale = null): mixed
    {
        $value = $this->content[$name] ?? null;

        $locale = $forceLocale ?? (
            config('translatable.use_property_fallback', false) && (! array_key_exists(
                app()->getLocale(),
                array_filter($value ?? []) ?? []
            ))
                ? config('translatable.fallback_locale')
                : app()->getLocale()
        );

        return $value[$locale] ?? null;
    }

    public function browserIds($name)
    {
        return isset($this->content['browsers']) ? ($this->content['browsers'][$name] ?? []) : [];
    }

    public function checkbox($name)
    {
        return isset($this->content[$name]) && ($this->content[$name][0] ?? $this->content[$name] ?? false);
    }

    public function getPresenterAttribute()
    {
        if ($presenter = config('twill.block_editor.block_presenter_path')) {
            return $presenter;
        }

        return null;
    }

    public function getTable()
    {
        return config('twill.blocks_table', 'twill_blocks');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query;
    }

    public function scopeAccessible(Builder $query): Builder
    {
        return $query;
    }

    public function scopeOnlyTrashed(Builder $query): Builder
    {
        return $query;
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query;
    }

    public function getTranslatedAttributes(): array
    {
        return [];
    }
}
