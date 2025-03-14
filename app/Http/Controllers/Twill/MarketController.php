<?php

namespace App\Http\Controllers\Twill;

use App\Models\City;
use A17\Twill\Models\User;
use A17\Twill\Services\Forms\Form;
use Illuminate\Support\Facades\Redirect;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\InlineRepeater;
use A17\Twill\Services\Forms\Fields\Repeater;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Market;
use App\Models\Interval;
use Illuminate\Http\Request;


class MarketController extends \App\Http\Controllers\Twill\AuthorizedBaseModuleController
{
    protected $moduleName = 'markets';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Магазин';
        $this->disablePermalink();
        $this->setTitleColumnKey('name');
        $this->setSearchColumns(['name']);

        if (!\Gate::allows('is_owner')) {
            $this->disableDelete();
        }


        $this->disableBulkDelete();
        $this->disableEditor();
    }

    /**
     * The quick filters to apply to the listing table.
     */
    public function quickFilters(): QuickFilters
    {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);


        $filters = [
            QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.all-items'))
                ->queryString('all'),
        ];

        // $filters[] = QuickFilter::make()
        //     ->label('Отключенные')
        //     ->queryString('draft')
        //     ->scope('draft')
        //     ->onlyEnableWhen($this->getIndexOption('publish'));

        if (\Gate::allows('is_owner')) {
            $filters[] = QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.trash'))
                ->queryString('trash')
                ->scope('onlyTrashed')
                ->onlyEnableWhen($this->getIndexOption('restore'))
                ->amount(fn() => $this->repository->getCountByStatusSlug('trash', $scope));
        }

        return QuickFilters::make($filters);
    }

    /**
     * Модальная форма создания
     *
     * @return Form
     */
    public function getCreateForm(): Form
    {

        return Form::make([

            Input::make()
                ->name('name')
                ->required()
                ->label('Название магазина'),
        ]);
    }

    public function authBy($marketId)
    {
        abort_if(!\Gate::allows('view-module', 'markets'), 403);
        abort_if(!in_array($marketId, auth()->user()->getMarketIds()) && !\Gate::allows('is_owner'), 403,);


        \Session::put('market_id', $marketId);
        return Redirect::back();
    }

    public function storeInterval(Request $request, $marketId)
    {
        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'close_time' => 'required|date_format:H:i',
            'close_time_behavior' => 'required|in:before,after',
        ]);

        try {
            $interval = Market::findOrFail($marketId)->intervals()->create([
                'start_time' => $this->timeToMinutes($validated['start_time']),
                'end_time' => $this->timeToMinutes($validated['end_time']),
                'close_time' => $this->timeToMinutes($validated['close_time']),
                'close_time_behavior' => $validated['close_time_behavior'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Интервал добавлен.',
                'interval' => [
                    'id' => $interval->id,
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'close_time' => $validated['close_time'],
                    'close_time_behavior' => $validated['close_time_behavior'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении интервала: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function bulkUpdateIntervals(Request $request)
    {
        $validatedData = $request->validate([
            'intervals' => 'required|array',
            'intervals.*.id' => 'required|exists:intervals,id',
            'intervals.*.start_time' => 'nullable|date_format:H:i',
            'intervals.*.end_time' => 'nullable|date_format:H:i|after:intervals.*.start_time',
            'intervals.*.close_time' => 'nullable|date_format:H:i',
            'intervals.*.close_time_behavior' => 'nullable|in:before,after',
        ]);
    
        try {
            $updatedIntervals = [];
    
            foreach ($validatedData['intervals'] as $intervalData) {
                $interval = Interval::findOrFail($intervalData['id']);
    
                // Формируем данные для обновления только из тех полей, которые переданы
                $fieldsToUpdate = [];
                if (isset($intervalData['start_time'])) {
                    $fieldsToUpdate['start_time'] = $this->timeToMinutes($intervalData['start_time']);
                }
                if (isset($intervalData['end_time'])) {
                    $fieldsToUpdate['end_time'] = $this->timeToMinutes($intervalData['end_time']);
                }
                if (isset($intervalData['close_time'])) {
                    $fieldsToUpdate['close_time'] = $this->timeToMinutes($intervalData['close_time']);
                }
                if (isset($intervalData['close_time_behavior'])) {
                    $fieldsToUpdate['close_time_behavior'] = $intervalData['close_time_behavior'];
                }
                if (!empty($fieldsToUpdate)) {
                    $interval->update($fieldsToUpdate);
                }
    
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Интервалы успешно обновлены.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении интервалов: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    


    /**
     * Преобразует время в формате HH:MM в минуты.
     */
    private function timeToMinutes($time)
    {
        [$hours, $minutes] = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    public function deleteInterval($intervalId)
    {
        try {
            $interval = Interval::findOrFail($intervalId);
            $interval->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function getIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            PublishStatus::make()
                ->title(twillTrans('twill::lang.listing.columns.published'))
                ->sortable()
                ->optional()
        );

        $title = Text::make()->field('name')->title('Название магазина');
        $title->linkToEdit();
        $title->sortable();
        $title->isDefaultSort();
        $table->push(
            $title
        );

        $field = Text::make()->field('address')->title('Адрес');
        $table->push(
            $field
        );

        $table->push(
            Text::make()->field('withdrawalFunds')->title('Доступно средств')->customRender(function ($market) {
                return $market->withdrawalFunds();
            })
        );

        $table->push(
            Text::make()->field('frozenFunds')->title('Замороженные')->customRender(function ($market) {
                return $market->frozenFunds();
            })
        );

        $field = Text::make()->field('address')->title('Адрес');

        $table->push(
            Text::make()->field('auth')->title('Авторизоваться')->renderHtml(true)->customRender(function ($model) {
                return '<form method="POST" action="' . route('twill.markets.auth', ['marketId' => $model->id]) . '">
                <input type="hidden" name="_token" value="' . csrf_token() . '">
                <button class="button button--' . (\Session::get('market_id') == $model->id ? 'green' : 'gray') . '" ' . (\Session::get('market_id') == $model->id ? 'disabled' : '') . ' type="submit">' . (\Session::get('market_id') == $model->id ? 'Текущий магазин' : 'Авторизоваться') . '</button>
                </form>';
            })
        );

        $status = isset($_GET['filter']) ? json_decode($_GET['filter'], true)['status'] : null;

        if (auth()->user()->role_id === 1 && $status != 'trash') {
            $table->push(
                Text::make()->field('deleted_at')->title('Удалить')->renderHtml(true)->customRender(function ($model) {
                    // dump($model->withdrawalFunds());
                    if ($model->withdrawalFunds() == 0) {
                        return '<form method="POST" action="' . route('twill.markets.delete', ['marketId' => $model->id]) . '">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button class="button button--red" style="background-color: red;" type="submit">В корзину</button>
                            </form>';
                    } else {
                        return '<button style="text-decoration: none;padding: 6px;background: #c7a2a2;border: none;color: white;" disabled>В корзину</button>';
                    }
                })
            );
        }

        return $table;
    }

    public function delete($marketId)
    {
        if (auth()->user()->role_id === 1) {
            $market = Market::where('id', $marketId)->first();
            $market->delete();
        }

        return Redirect::back();
    }
}
