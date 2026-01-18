<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\MultiSelect;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\InlineRepeater;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Category;
use App\Models\DateInterval;
use App\Models\GroupProductCategory;
use App\Models\Market;
use App\Models\NameDateInterval;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class NameDateIntervalController extends BaseModuleController
{
    protected $moduleName = 'nameDateIntervals';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();

        $this->modelTitle = 'Инетвалы доствки по дням';

        $this->setTitleColumnKey('date');
        $this->setSearchColumns(['date']);


    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */

    protected function getIndexTableColumns(): TableColumns
    {
        $table = new TableColumns();


        $table->add(Text::make()->field('date')->title('Даты'));
        $table->add(Text::make()->field('market.name')->title('Магазин'));





        return $table;
    }

/*    public function getForm(TwillModelContract $model): Form
    {
        $categoris = Category::where('id', 1)->orWhere('parent_id', 1) ->pluck('id')->toArray();

        return Form::make([
            Select::make()
                ->searchable() // ← включает поиск
                ->name('title')
                ->options(
                    Product::whereIn('category_id', $categoris)->get()->map(function ($product) {
                        return [
                            'value' => $product->id,
                            'label' => $product->title,
                        ];
                    })->toArray()
                ),


            Input::make()
                ->name('sort')
                ->label('Сортировка')
                ->required(true),
            InlineRepeater::make()->name('intervals')
                ->fields([
                    Input::make()->name('title'),
                    Input::make()->name('url'),
                ])
        ]);
    }*/
    public function formData($request)
    {
        return [
            'flovers' => Product::all()->map(function ($product) {
                return [
                    'value' => $product->id,
                    'label' => $product->title,
                ];
            })->toArray(),
        ];
    }
    public function getCreateForm(): Form
    {



        return Form::make([
            DatePicker::make()
                ->name('date')  // имя поля в БД
                ->label('Дата')->withoutTime()
                ->placeholder('Выберите дату')
                ->required(),

        Select::make()
                ->searchable() // ← включает поиск
                ->name('market_id')
                ->label('Магазин')
                ->options(
                    Market::all()->map(function ($product) {
                        return [
                            'value' => $product->id,
                            'label' => $product->name,
                        ];
                    })->toArray()
                )  ->required(),


        ]);
    }

    public function storeDateInterval(Request $request, $nameDateId)
    {
        $validated = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'close_time' => 'required|date_format:H:i',
            'close_time_behavior' => 'required|in:before,after',
        ]);
$nameDateInterval = NameDateInterval::find(  $nameDateId);
        try {
            $interval = DateInterval::create([
                'start_time' => $this->timeToMinutes($validated['start_time']),
                'start_time' => $this->timeToMinutes($validated['start_time']),
                'end_time' => $this->timeToMinutes($validated['end_time']),
                'close_time' => $this->timeToMinutes($validated['close_time']),
                'close_time_behavior' => $validated['close_time_behavior'],
                'market_id' => $nameDateInterval->market_id,
                'date' => $nameDateInterval->date,
                'name_date_interval_id' => $nameDateId,
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
                'message' => 'Ошибка при добавлении интервала: '.$e->getMessage(),
            ], 500);
        }
    }
    private function timeToMinutes($time)
    {
        [$hours, $minutes] = explode(':', $time);

        return $hours * 60 + $minutes;
    }

    public function deleteDateInterval($intervalId)
    {
        try {
            $interval = DateInterval::findOrFail($intervalId);
            $interval->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function bulkUpdateDateIntervals(Request $request)
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
                $interval = DateInterval::findOrFail($intervalData['id']);

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
                if (! empty($fieldsToUpdate)) {
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
                'message' => 'Ошибка при обновлении интервалов: '.$e->getMessage(),
            ], 500);
        }
    }

}
