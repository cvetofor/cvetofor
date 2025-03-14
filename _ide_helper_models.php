<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace A17\Twill\Models{
/**
 * A17\Twill\Models\Block
 *
 * @property int $id
 * @property int|null $blockable_id
 * @property string|null $blockable_type
 * @property int $position
 * @property array $content
 * @property string $type
 * @property string|null $child_key
 * @property int|null $parent_id
 * @property string|null $editor_name
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $blockable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Block> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\File> $files
 * @property-read int|null $files_count
 * @property-read mixed $presenter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Block accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Block draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Block editor($name = 'default')
 * @method static \Illuminate\Database\Eloquent\Builder|Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Block published()
 * @method static \Illuminate\Database\Eloquent\Builder|Block query()
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereBlockableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereBlockableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereChildKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereEditorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereType($value)
 */
	class Block extends \Eloquent implements \A17\Twill\Models\Contracts\TwillModelContract {}
}

namespace A17\Twill\Models{
/**
 * A17\Twill\Models\File
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $uuid
 * @property string|null $filename
 * @property int $size
 * @property int|null $market_id
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File unused()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|File withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|File withoutTrashed()
 */
	class File extends \Eloquent {}
}

namespace A17\Twill\Models{
/**
 * A17\Twill\Models\Media
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $uuid
 * @property string|null $alt_text
 * @property int $width
 * @property int $height
 * @property string|null $caption
 * @property string|null $filename
 * @property int|null $market_id
 * @property-read mixed $dimensions
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media unused()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereAltText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Media withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Media withoutTrashed()
 */
	class Media extends \Eloquent {}
}

namespace A17\Twill\Models{
/**
 * A17\Twill\Models\User
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property string|null $title
 * @property string|null $description
 * @property string|null $remember_token
 * @property string|null $language
 * @property string|null $google_2fa_secret
 * @property bool $google_2fa_enabled
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property \Illuminate\Support\Carbon|null $registered_at
 * @property bool $require_new_password
 * @property int|null $role_id
 * @property bool $is_superadmin
 * @property string|null $second_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property bool|null $send_notify_email
 * @property bool|null $send_notify_phone
 * @property int|null $market_id
 * @property int|null $master_user_id
 * @property-read mixed $can_delete
 * @property mixed $google2fa_secret
 * @property-read mixed $last_login_column_value
 * @property-read mixed $market
 * @property-read mixed $role_value
 * @property-read mixed $title_in_browser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market> $markets
 * @property-read int|null $markets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\UserOauth> $providers
 * @property-read int|null $providers_count
 * @property-read \A17\Twill\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market> $stores
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|User accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|User activated()
 * @method static \Illuminate\Database\Eloquent\Builder|User draft()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User notSuperAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User pending()
 * @method static \Illuminate\Database\Eloquent\Builder|User published()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogle2faEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSuperadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMasterUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRequireNewPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSecondName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSendNotifyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSendNotifyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \A17\Twill\Models\Contracts\TwillModelContract {}
}

namespace App\Models{
/**
 * App\Models\Attribute
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $label
 * @property bool $is_variable Показатель вариативности продукта
 * @property \Illuminate\Support\Carbon|null $variable_generated_at Дата генерации вариативного товара
 * @property int|null $product_id
 * @property-read \App\Models\Product|null $products
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereIsVariable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereVariableGeneratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute withoutTrashed()
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Balance
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Balance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Balance withoutTrashed()
 */
	class Balance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property int|null $position
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property bool $is_visible Категория товаров доступна для выбора в букетах, но невидима покупателю
 * @property bool $is_visible_menu Показывает элементы в меню
 * @property bool $is_additional_product Товар можно положить в корзину без букета
 * @property-read \A17\Twill\Models\NestedsetCollection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read string $ancestors_slug
 * @property-read string $nested_slug
 * @property-read string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read Category|null $parent
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\CategorySlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model accessible()
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model draft()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category fixTree($root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category forFallbackLocaleSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category forInactiveSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category forSlug(string $slug)
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category ordered()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model published()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model publishedInListings()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model visible()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereDeletedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereDescription($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsAdditionalProduct($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsVisible($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereIsVisibleMenu($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category wherePosition($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category wherePublished($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model whereTag($tags, string $type = 'slug')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereTitle($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Category withoutRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $position
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $federal_district
 * @property string|null $region_type
 * @property string|null $region
 * @property string|null $area_type
 * @property string|null $area
 * @property string|null $city_type
 * @property string|null $city
 * @property string|null $settlement_type
 * @property string|null $settlement
 * @property string|null $kladr_id
 * @property string|null $fias_id
 * @property string|null $fias_level
 * @property string|null $capital_marker
 * @property string|null $okato
 * @property string|null $oktmo
 * @property string|null $tax_office
 * @property string|null $timezone
 * @property string|null $geo_lat
 * @property string|null $geo_lon
 * @property string|null $population
 * @property string|null $foundation_year
 * @property int|null $region_id
 * @property-read void $parent_case
 * @property-read string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Market> $markets
 * @property-read int|null $markets_count
 * @property-read \App\Models\Region|null $province
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\CitySlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|City active()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|City forFallbackLocaleSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|City forInactiveSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|City forSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|City ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAreaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCapitalMarker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFederalDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFiasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFiasLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereFoundationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGeoLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGeoLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereKladrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereOkato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereOktmo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRegionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSettlement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSettlementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTaxOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|City withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|City withoutTrashed()
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Color
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property int|null $position
 * @property array|null $data
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Color ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Color withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Color withoutTrashed()
 */
	class Color extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\Delivery
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $city_id
 * @property int|null $order_id
 * @property array|null $address
 * @property string $km
 * @property string $price
 * @property-read mixed $title
 * @property-read \App\Models\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\DeliveryRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery atWork()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery delivered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery withoutTrashed()
 */
	class Delivery extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryStatus
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $code
 * @property string|null $description
 * @property int|null $position
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryStatus withoutTrashed()
 */
	class DeliveryStatus extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\Form
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $comment
 * @property string|null $page
 * @property string|null $ip
 * @property int|null $city_id
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Form withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Form withoutTrashed()
 */
	class Form extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupProduct
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property int|null $category_id
 * @property int|null $created_by_market_id
 * @property bool $is_public
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \App\Models\GroupProductCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\File> $files
 * @property-read int|null $files_count
 * @property mixed $is_custom_price
 * @property bool $is_promo
 * @property mixed $price
 * @property-read mixed $public_price
 * @property-read string $slug
 * @property-read mixed $social_image
 * @property-read \App\Models\GroupProductCategory|null $groupProductCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \CwsDigital\TwillMetadata\Models\Metadata|null $metadata
 * @property-read \App\Models\ProductPrice|null $priceObj
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductPrice> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Remain> $remains
 * @property-read int|null $remains_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\GroupProductRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\GroupProductSlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct all()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct allGroupPoruductBelongsMarket()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct common()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct currentCity()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct currentMarket()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct draft()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct forFallbackLocaleSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct forInactiveSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct forSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct inStock()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct mine()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct search()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereCreatedByMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProduct withoutTrashed()
 */
	class GroupProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupProductCategory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property int|null $position
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \A17\Twill\Models\NestedsetCollection<int, GroupProductCategory> $children
 * @property-read int|null $children_count
 * @property-read string $ancestors_slug
 * @property-read string $nested_slug
 * @property-read string $slug
 * @property-read mixed $social_image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \CwsDigital\TwillMetadata\Models\Metadata|null $metadata
 * @property-read GroupProductCategory|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupProduct> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\GroupProductCategoryRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\GroupProductCategorySlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model accessible()
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model draft()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory fixTree($root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory forFallbackLocaleSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory forInactiveSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory forSlug(string $slug)
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory mine()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory ordered()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model published()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model publishedInListings()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model visible()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereDeletedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereDescription($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory wherePosition($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory wherePublished($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model whereTag($tags, string $type = 'slug')
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereTitle($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategory withTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|GroupProductCategory withoutRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategory withoutTrashed()
 */
	class GroupProductCategory extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\Hollyday
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $begin_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Hollyday withoutTrashed()
 */
	class Hollyday extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LegalAccount
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $recipient
 * @property string|null $address
 * @property string|null $recipient_account
 * @property string|null $bik
 * @property string|null $bank
 * @property string|null $correspondent_account
 * @property string|null $inn
 * @property string|null $kpp
 * @property int|null $order_id
 * @property-read \App\Models\Order|null $order
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereBik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereCorrespondentAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereRecipientAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|LegalAccount withoutTrashed()
 */
	class LegalAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Market
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $name Название магазина
 * @property int|null $user_id 1
 * @property int|null $market_work_times_id 1
 * @property int|null $market_delivery_times_id 1
 * @property int|null $city_id 1
 * @property string|null $address Адрес
 * @property string|null $phone 1
 * @property string|null $email 1
 * @property string|null $order_prepaid 1
 * @property string|null $card 1
 * @property string|null $card_holder_fio 1
 * @property string|null $delivery_time_order_interval 1
 * @property string|null $delivery_min_time 1
 * @property string|null $delivery_normal_price 1
 * @property string|null $delivery_night_price 1
 * @property string|null $free_delivery_price_order 1
 * @property string|null $delivery_radius 1
 * @property string|null $delivery_out_town_km_price 1
 * @property string|null $additional_service_photo_price 1
 * @property string|null $additional_service_hot_delivery_price 1
 * @property string|null $additional_service_to_current_time_price 1
 * @property string|null $holidays_percent 1
 * @property string|null $holidays_delivery_price 1
 * @property string|null $holidays_radius 1
 * @property string|null $holidays_out_town_km_price 1
 * @property \Illuminate\Support\Carbon|null $publish_start_date
 * @property \Illuminate\Support\Carbon|null $publish_end_date
 * @property string|null $postcard_price 1
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\MarketWorkTime|null $delivery_times
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\User> $employees
 * @property-read int|null $employees_count
 * @property-read mixed $delivery_price
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductPrice> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\MarketRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \A17\Twill\Models\User|null $user
 * @property-read \App\Models\MarketWorkTime|null $work_times
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Market mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Market newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Market newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Market published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Market query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereAdditionalServiceHotDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereAdditionalServicePhotoPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereAdditionalServiceToCurrentTimePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereCardHolderFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryMinTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryNightPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryNormalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryOutTownKmPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereDeliveryTimeOrderInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereFreeDeliveryPriceOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereHolidaysDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereHolidaysOutTownKmPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereHolidaysPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereHolidaysRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereMarketDeliveryTimesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereMarketWorkTimesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereOrderPrepaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market wherePostcardPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market wherePublishEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market wherePublishStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Market whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Market withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Market withoutTrashed()
 */
	class Market extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MarketWorkTime
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property array|null $times
 * @property-read \App\Models\Market|null $delivery
 * @property-read mixed $title
 * @property-read \App\Models\Market|null $market
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\MarketWorkTimeRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime mine()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime whereTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTime withoutTrashed()
 */
	class MarketWorkTime extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $market_id
 * @property int $payment_id
 * @property int|null $user_id
 * @property int|null $city_id
 * @property int|null $payment_status_id
 * @property int|null $delivery_status_id
 * @property int|null $order_status_id
 * @property string $uuid
 * @property string|null $email
 * @property string|null $phone
 * @property array|null $address
 * @property string|null $comment
 * @property string|null $market_comment
 * @property bool $is_photo_needle
 * @property bool $is_anon
 * @property string|null $delivery_date
 * @property string|null $delivery_time
 * @property string|null $total_price
 * @property string|null $postcard_text
 * @property bool|null $is_policy_accepted
 * @property string|null $person_receiving_name
 * @property string|null $person_receiving_phone
 * @property string|null $payment_link
 * @property array|null $cart
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property \App\Values\MetaOrder $meta
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $childs
 * @property-read int|null $childs_count
 * @property-read \App\Models\Delivery|null $delivery
 * @property-read \App\Models\DeliveryStatus|null $deliveryStatus
 * @property mixed $delivery_price
 * @property-read mixed $title
 * @property-read \App\Models\LegalAccount|null $legalAccount
 * @property-read \App\Models\Market|null $market
 * @property-read \App\Models\OrderStatus|null $orderStatus
 * @property-read Order|null $parent
 * @property-read \App\Models\Payment $payment
 * @property-read \App\Models\PaymentStatus|null $paymentStatus
 * @property-read \App\Models\Review|null $review
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\OrderRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order accepted()
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Order closed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order currentMarket()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Order issued()
 * @method static \Illuminate\Database\Eloquent\Builder|Order mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order succesfuled()
 * @method static \Illuminate\Database\Eloquent\Builder|Order tender()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsAnon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsPhotoNeedle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsPolicyAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMarketComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePersonReceivingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePersonReceivingPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePostcardText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string $price
 * @property string $title
 * @property string $quantity
 * @property int|null $product_id
 * @property int|null $order_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\File> $files
 * @property-read int|null $files_count
 * @property-read string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\OrderItemRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\OrderItemSlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\Translations\OrderItemTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Translations\OrderItemTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem forFallbackLocaleSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem forInactiveSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem forSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem mine()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem orderByRawByTranslation($orderRawString, $groupByField, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem orderByTranslation($orderField, $orderType = 'ASC', $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem translated()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withActiveTranslations(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withTranslation()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem withoutTrashed()
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatus
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $code
 * @property string|null $description
 * @property int|null $position
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus withoutTrashed()
 */
	class OrderStatus extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property int|null $position
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \A17\Twill\Models\NestedsetCollection<int, Page> $children
 * @property-read int|null $children_count
 * @property-read string $ancestors_slug
 * @property-read string $nested_slug
 * @property-read string $slug
 * @property-read mixed $social_image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read \CwsDigital\TwillMetadata\Models\Metadata|null $metadata
 * @property-read Page|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\PageRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\PageSlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model accessible()
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model draft()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page fixTree($root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page forFallbackLocaleSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page forInactiveSlug(string $slug)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page forSlug(string $slug)
 * @method static \A17\Twill\Models\NestedsetCollection<int, static> get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page mine()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page ordered()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model published()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model publishedInListings()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model visible()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereDeletedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereDescription($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereLft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereNodeBetween($values, $boolean = 'and', $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page wherePosition($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page wherePublished($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereRgt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model whereTag($tags, string $type = 'slug')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereTitle($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page withDepth(string $as = 'depth')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Page withoutRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Page withoutTrashed()
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $position
 * @property string|null $name
 * @property string|null $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 */
	class Payment extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\PaymentDetail
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $user_id
 * @property bool $approved
 * @property string|null $fio
 * @property string|null $legal_address
 * @property string|null $postal_address
 * @property string|null $inn
 * @property string|null $kpp
 * @property string|null $ogrn
 * @property string|null $bank_fullname
 * @property string|null $payment_account
 * @property string|null $correspondent_account
 * @property string|null $bik
 * @property string|null $publish_start_date
 * @property string|null $publish_end_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\PaymentDetailRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail mine()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereBankFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereBik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereCorrespondentAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereLegalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereOgrn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail wherePaymentAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail wherePostalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail wherePublishEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail wherePublishStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetail withoutTrashed()
 */
	class PaymentDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentStatus
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $code
 * @property string|null $description
 * @property int|null $position
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentStatus withoutTrashed()
 */
	class PaymentStatus extends \Eloquent implements \A17\Twill\Models\Behaviors\Sortable {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property int|null $market_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $is_market_public
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \App\Models\Category|null $category
 * @property-read string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Media> $medias
 * @property-read int|null $medias_count
 * @property-read Product|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductPrice> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Remain> $remains
 * @property-read int|null $remains_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\ProductRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $skus
 * @property-read int|null $skus_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Slugs\ProductSlug> $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Product draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Product forFallbackLocaleSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Product forInactiveSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Product forSlug(string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder|Product mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Product waitToCheckAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsMarketPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductPrice
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $product_id
 * @property int|null $group_product_id
 * @property int|null $market_id
 * @property string|null $price
 * @property string|null $quantity_from
 * @property string|null $sku
 * @property bool $is_custom_price
 * @property bool|null $is_promo
 * @property-read mixed $link
 * @property-read mixed $public_price
 * @property-read \App\Models\GroupProduct|null $groupProduct
 * @property-read \App\Models\Market|null $market
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\ProductPriceRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice currentMarketGroupProductPrice($marketId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice currentMarketProductPrice($marketId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice mine()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice orderByPrice()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice priceFilter()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereGroupProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereIsCustomPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereIsPromo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereQuantityFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice withoutTrashed()
 */
	class ProductPrice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int $user_id
 * @property mixed $concent_exclusive_email
 * @property mixed $email
 * @property mixed $last_name
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $second_name
 * @property-read mixed $title
 * @property-write mixed $password
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Profile withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Profile withoutTrashed()
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $position
 * @property string|null $name
 * @property string|null $type
 * @property string|null $name_with_type
 * @property string|null $federal_district
 * @property string|null $kladr_id
 * @property string|null $fias_id
 * @property string|null $okato
 * @property string|null $oktmo
 * @property string|null $tax_office
 * @property string|null $postal_code
 * @property string|null $iso_code
 * @property string|null $timezone
 * @property string|null $geoname_code
 * @property string|null $geoname_id
 * @property string|null $geoname_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\City> $cities
 * @property-read int|null $cities_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Region ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereFederalDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereFiasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereGeonameCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereGeonameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereGeonameName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereKladrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereNameWithType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereOkato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereOktmo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereTaxOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Region withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Region withoutTrashed()
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Remain
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property int|null $product_id
 * @property int|null $group_product_id
 * @property int|null $market_id
 * @property int $quantity
 * @property int $position
 * @property-read mixed $price
 * @property-read \App\Models\GroupProduct|null $groupProduct
 * @property-read \App\Models\Market|null $market
 * @property-read \App\Models\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\RemainRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain currentMarket()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereGroupProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Remain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Remain withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Remain withoutTrashed()
 */
	class Remain extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string|null $description
 * @property mixed|null $additional
 * @property int|null $user_id
 * @property int|null $order_id
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Review withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Review withoutTrashed()
 */
	class Review extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\CategoryRevision
 *
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryRevision query()
 */
	class CategoryRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\DeliveryRevision
 *
 * @property int $id
 * @property int $delivery_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision whereDeliveryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryRevision whereUserId($value)
 */
	class DeliveryRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\GroupProductCategoryRevision
 *
 * @property int $id
 * @property int $group_product_category_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision whereGroupProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategoryRevision whereUserId($value)
 */
	class GroupProductCategoryRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\GroupProductRevision
 *
 * @property int $id
 * @property int $group_product_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision whereGroupProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductRevision whereUserId($value)
 */
	class GroupProductRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\MarketRevision
 *
 * @property int $id
 * @property int $market_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketRevision whereUserId($value)
 */
	class MarketRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\MarketWorkTimeRevision
 *
 * @property int $id
 * @property int $market_work_time_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision whereMarketWorkTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketWorkTimeRevision whereUserId($value)
 */
	class MarketWorkTimeRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\OrderItemRevision
 *
 * @property int $id
 * @property int $order_item_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemRevision whereUserId($value)
 */
	class OrderItemRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\OrderRevision
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRevision whereUserId($value)
 */
	class OrderRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\PageRevision
 *
 * @property int $id
 * @property int $page_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereUserId($value)
 */
	class PageRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\PaymentDetailRevision
 *
 * @property int $id
 * @property int $payment_detail_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision wherePaymentDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentDetailRevision whereUserId($value)
 */
	class PaymentDetailRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\PaymentRevision
 *
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRevision query()
 */
	class PaymentRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\ProductPriceRevision
 *
 * @property int $id
 * @property int $product_price_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision whereProductPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPriceRevision whereUserId($value)
 */
	class ProductPriceRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\ProductRevision
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRevision whereUserId($value)
 */
	class ProductRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\RemainRevision
 *
 * @property int $id
 * @property int $remain_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision whereRemainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainRevision whereUserId($value)
 */
	class RemainRevision extends \Eloquent {}
}

namespace App\Models\Revisions{
/**
 * App\Models\Revisions\StockRevision
 *
 * @property int $id
 * @property int $stock_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $payload
 * @property-read mixed $by_user
 * @property-read \A17\Twill\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockRevision whereUserId($value)
 */
	class StockRevision extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\CategorySlug
 *
 * @property int $id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CategorySlug withoutTrashed()
 */
	class CategorySlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\CitySlug
 *
 * @property int $id
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CitySlug withoutTrashed()
 */
	class CitySlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\GroupProductCategorySlug
 *
 * @property int $id
 * @property int $group_product_category_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereGroupProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductCategorySlug withoutTrashed()
 */
	class GroupProductCategorySlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\GroupProductSlug
 *
 * @property int $id
 * @property int $group_product_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereGroupProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductSlug withoutTrashed()
 */
	class GroupProductSlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\OrderItemSlug
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemSlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemSlug withoutTrashed()
 */
	class OrderItemSlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\PageSlug
 *
 * @property int $id
 * @property int $page_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PageSlug withoutTrashed()
 */
	class PageSlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\ProductSlug
 *
 * @property int $id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property bool $active
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSlug withoutTrashed()
 */
	class ProductSlug extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $published
 * @property string|null $title
 * @property string $code
 * @property int $quantity
 * @property int|null $percent
 * @property string|null $price
 * @property int|null $market_id
 * @property string|null $publish_start_date
 * @property string|null $publish_end_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\RelatedItem> $relatedItems
 * @property-read int|null $related_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Revisions\StockRevision> $revisions
 * @property-read int|null $revisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock mine()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePublishEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePublishStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Stock withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Stock withoutTrashed()
 */
	class Stock extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\CategoryTranslation
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation withoutTrashed()
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\GroupProductTranslation
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|GroupProductTranslation withoutTrashed()
 */
	class GroupProductTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\OrderItemTranslation
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItemTranslation withoutTrashed()
 */
	class OrderItemTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\PageTranslation
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation withoutTrashed()
 */
	class PageTranslation extends \Eloquent {}
}

namespace App\Models\Translations{
/**
 * App\Models\Translations\ProductTranslation
 *
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \A17\Twill\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Model accessible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Model withTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Model withoutTag($tags, string $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation withoutTrashed()
 */
	class ProductTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $second_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $phone
 * @property bool $concent_exclusive_email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConcentExclusiveEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSecondName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

