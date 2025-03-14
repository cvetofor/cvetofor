<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Balance;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BalanceController extends \App\Http\Controllers\Twill\AuthorizedBaseModuleController
{
    protected $moduleName = 'balances';


    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Баланс';

        $this->setSearchColumns([
            'title',
        ]);

        $this->disableSortable();
        $this->disablePublish();
        $this->disableBulkPublish();
        $this->disableRestore();
        $this->disableBulkRestore();
        $this->disableForceDelete();
        $this->disableBulkForceDelete();
        $this->disableBulkDelete();
        $this->disablePermalink();
        $this->disableEditor();
        $this->disableBulkEdit();
        $this->disableIncludeScheduledInList();

        $this->disableCreate();
        #$this->disableDelete();
    }

    public function destroy(int|TwillModelContract $id, ?int $submoduleId = null): JsonResponse
    {
        abort_unless(\Gate::allows('is_owner'), 403);

        [$item, $id] = $this->itemAndIdFromRequest($id);

        $result = \DB::transaction(function () use ($item) {
            $item->orders()->detach();
            return $item->forceDelete();
        }, 3);

        if ($result) {
            $this->fireEvent();
            activity()->performedOn($item)->log('deleted');

            return $this->respondWithSuccess(
                twillTrans('twill::lang.listing.delete.success', ['modelTitle' => $this->modelTitle])
            );
        }

        return $this->respondWithError(
            twillTrans('twill::lang.listing.delete.error', ['modelTitle' => $this->modelTitle])
        );
    }


    protected function getIndexData(array $prependScope = []): array
    {
        $data = parent::getIndexData($prependScope);

        # $data['create'] = \Gate::allows('is_owner');

        foreach ($data['tableData'] as $i => $item) {
            if (
                !\Gate::allows('is_owner')
            ) {
                $balance = Balance::where('id', $item['id'])->first();
                $data['tableData'][$i]['title'] = $balance->title ?? '';
                $data['tableData'][$i]['edit'] = false;
                $data['tableData'][$i]['delete'] = \Gate::allows('is_owner') && $item->status !== Balance::STATUS['APPROVED'] ? route('twill.orders.destroy', ['order' => $item['id']]) : false;
            }
        }
        return $data;
    }


    public function index(?int $parentModuleId = null): mixed
    {
        return parent::index($parentModuleId);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $table = new TableColumns;

        $table->add(
            Text::make()->field('id')->title('№ '),
        );

        $table->add(
            Text::make()->field('market')->title('Магазин ')->renderHtml(true)->customRender(function ($object) {
                return $object->market->name ?? '';
            }),
        );

        $table->add(
            Text::make()->field('created_at')->title('Время (Москва)'),
        );
        $table->add(
            Text::make()->field('title')->title('Комментарий'),
        );
        $table->add(
            Text::make()->field('total')->title('Сумма, ₽'),
        );

        return $table;
    }

    public function recalc(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        \Artisan::call('marketplace:payments');
        return back();
    }

    public function additionalTableActions()
    {
        $balance = [
            'Available' => [
                // Action name.
                'name'    => 'доступно ' . auth()->user()->market->withdrawalFunds() . ' ₽',
                // Button action title.
                'variant' => 'aslink-grey',
                // Button style variant. Available variants; primary, secondary, action, editor, validate, aslink, aslink-grey, warning, ghost, outline, tertiary
                'size'    => 'small',
                // Button size. Available sizes; small
                'link'    => '',
                // Button action link.
                'target'  => '',
                // Leave it blank for self.
                'type'    => 'a',
                // Leave it blank for "button".
            ],
        ];

        if (\Gate::allows('is_owner')) {
            $balance['recalc'] = [
                // Action name.
                'name'    => 'Рассчитать сейчас',
                // Button action title.
                'variant' => 'primary',
                // Button style variant. Available variants; primary, secondary, action, editor, validate, aslink, aslink-grey, warning, ghost, outline, tertiary
                'size'    => 'small',
                // Button size. Available sizes; small
                'link'    => \URL::signedRoute('twill.balances.recalc', ['id' => auth()->user()->id]),
                // Button action link.
                'target'  => '_blank',
                // Leave it blank for self.
                'type'    => 'a',
                // Leave it blank for "button".
            ];
        }

        return $balance;
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters
    {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        return QuickFilters::make([
            QuickFilter::make()
                ->label('Подтвержденные')
                ->queryString('approved')
                ->scope('approved')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->approved()->count()),
            QuickFilter::make()
                ->label('На подтверждении')
                ->queryString('waitApprove')
                ->scope('waitApprove')
                ->amount(fn() => $this->repository->filter($this->repository->getBaseModel())->waitApprove()->count()),
        ]);
    }
}
