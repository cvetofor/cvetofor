<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Browser;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumn;
use A17\Twill\Services\Listings\TableColumns;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AuthorizedBaseModuleController extends BaseModuleController
{
    protected function setUpController(): void
    {
        if (! \Gate::allows('is_owner')) {
            $this->disablePublish();
            $this->disableBulkPublish();
            $this->disableRestore();
            $this->disableBulkRestore();
            $this->disableForceDelete();
            $this->disableBulkForceDelete();
            $this->disableDelete();
            $this->disableBulkDelete();
            $this->disableBulkEdit();
            $this->disableIncludeScheduledInList();
        }

        $this->disablePermalink();
        $this->disableEditor();

        parent::setUpController();
    }

    public function edit(TwillModelContract|int $id): mixed
    {
        [$item, $id] = $this->itemAndIdFromRequest($id);
        abort_unless(auth()->user()->can('edit', $item), 403);

        return parent::edit($id);
    }

    public function store($parentModuleId = null)
    {
        return parent::store($parentModuleId);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function reorder()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::reorder();
    }

    public function duplicate(int|TwillModelContract $id, ?int $submoduleId = null): JsonResponse
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::duplicate($id, $submoduleId);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function feature()
    {
        $id = $this->request->get('id');
        abort_unless(auth()->user()->can('edit', $this->repository->getBaseModel()->where('id', $id)->first()), 403);

        return parent::feature();
    }

    public function forceDelete()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::forceDelete();
    }

    public function preview(int $id): IlluminateView
    {
        abort_unless(auth()->user()->can('edit', $this->repository->getBaseModel()->where('id', $id)->first()), 403);

        return parent::preview($id);
    }

    public function publish(): JsonResponse
    {
        return parent::publish();
    }

    public function restore()
    {
        return parent::restore();
    }

    public function bulkDelete()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::bulkDelete();
    }

    public function bulkFeature()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::bulkFeature();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkForceDelete()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::bulkForceDelete();
    }

    public function bulkPublish(): JsonResponse
    {
        $items = $this->repository->getBaseModel()->whereIn('id', explode(',', $this->request->get('ids') ?? []))->get();

        foreach ($items as $item) {
            abort_unless(auth()->user()->can('edit', $item), 403);
        }

        return parent::bulkPublish();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkRestore()
    {
        abort_unless(auth()->user()->can('is_owner'), 403);

        return parent::bulkRestore();
    }

    /**
     * When set to true and the model is translatable, the language prefix will not be shown in the permalink.
     */
    private bool $withoutLanguageInPermalink = false;

    private ?\A17\Twill\Services\Breadcrumbs $breadcrumbs = null;

    protected function itemAndIdFromRequest(TwillModelContract|int $id): array
    {
        if ($id instanceof TwillModelContract) {
            $item = $id;
            $id = $item->id;
        } else {
            $parameter = Str::singular(Str::afterLast($this->moduleName, '.'));
            $id = (int) $this->request->route()->parameter($parameter, $id);
            $item = $this->repository->getById($id, $this->formWith, $this->formWithCount);
        }

        return [
            $item,
            $id,
        ];
    }

    private function getTableColumns(string $type): TableColumns
    {
        if ($type === 'index') {
            $tableColumns = $this->getIndexTableColumns();
        } else {
            $tableColumns = $this->getBrowserTableColumns();
        }

        return $tableColumns->each(function (TableColumn $column) {
            if ($column instanceof NestedData) {
                $column->linkCell(function (TwillModelContract $model, NestedData $column) {
                    $module = Str::singular(last(explode('.', $this->moduleName)));

                    return moduleRoute(
                        "$this->moduleName.".$column->getField(),
                        $this->routePrefix,
                        'index',
                        [$module => $this->getItemIdentifier($model)]
                    );
                });
            } elseif ($column->shouldLinkToEdit()) {
                $column->linkCell(function (TwillModelContract $model) {
                    if ($model->trashed()) {
                        return null;
                    }

                    if ($this->getIndexOption('edit', $model)) {
                        return $this->getModuleRoute($model->id, 'edit');
                    }
                });
            }
        });
    }

    private function handleLegacyColumns(TableColumns $columns, array $items): void
    {
        foreach ($items as $key => $indexColumn) {
            if ($indexColumn['nested'] ?? false) {
                $columns->add(
                    NestedData::make()
                        ->title($indexColumn['title'] ?? null)
                        ->field($indexColumn['nested'])
                        ->sortKey($indexColumn['sortKey'] ?? null)
                        ->sortable($indexColumn['sort'] ?? false)
                        ->optional($indexColumn['optional'] ?? false)
                        ->linkCell(function (TwillModelContract $model) use ($indexColumn) {
                            $module = Str::singular(last(explode('.', $this->moduleName)));

                            return moduleRoute(
                                "$this->moduleName.{$indexColumn['nested']}",
                                $this->routePrefix,
                                'index',
                                [$module => $this->getItemIdentifier($model)]
                            );
                        })
                );
            } elseif ($indexColumn['thumb'] ?? false) {
                $columns->add(
                    Image::make()
                        ->title($indexColumn['title'] ?? $key)
                        ->role($indexColumn['variant']['role'] ?? null)
                        ->crop($indexColumn['variant']['crop'] ?? null)
                        ->field($indexColumn['field'] ?? $key)
                        ->sortKey($indexColumn['sortKey'] ?? null)
                        ->optional($indexColumn['optional'] ?? false)
                );
            } elseif ($indexColumn['relatedBrowser'] ?? false) {
                $columns->add(
                    Browser::make()
                        ->title($indexColumn['title'])
                        ->field($indexColumn['field'] ?? $key)
                        ->sortKey($indexColumn['sortKey'] ?? null)
                        ->optional($indexColumn['optional'] ?? false)
                        ->browser($indexColumn['relatedBrowser'])
                );
            } elseif ($indexColumn['relationship'] ?? false) {
                $columns->add(
                    Relation::make()
                        ->title($indexColumn['title'])
                        ->field($indexColumn['field'] ?? $key)
                        ->sortKey($indexColumn['sortKey'] ?? null)
                        ->optional($indexColumn['optional'] ?? false)
                        ->relation($indexColumn['relationship'])
                );
            } elseif ($indexColumn['present'] ?? false) {
                $columns->add(
                    Presenter::make()
                        ->title($indexColumn['title'])
                        ->field($indexColumn['field'] ?? $key)
                        ->sortKey($indexColumn['sortKey'] ?? null)
                        ->optional($indexColumn['optional'] ?? false)
                        ->sortable($indexColumn['sort'] ?? false)
                );
            } else {
                $textColumn = Text::make()
                    ->title($indexColumn['title'] ?? null)
                    ->field($indexColumn['field'] ?? $key)
                    ->sortKey($indexColumn['sortKey'] ?? null)
                    ->optional($indexColumn['optional'] ?? false)
                    ->sortable($indexColumn['sort'] ?? false);

                // If it is a the title, we always want to link it.
                if ($this->titleColumnKey === ($indexColumn['field'] ?? $key)) {
                    $textColumn->linkCell(function (TwillModelContract $model) {
                        if ($this->getIndexOption('edit', $model)) {
                            return $this->getModuleRoute($model->id, 'edit');
                        }
                    });
                }
                $columns->add($textColumn);
            }
        }
    }
}
