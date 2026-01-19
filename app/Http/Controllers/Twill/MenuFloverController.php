<?php

namespace App\Http\Controllers\Twill;
use Illuminate\Database\Schema\Blueprint;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Forms\Fields\MultiSelect;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Category;
use App\Models\GroupProductCategory;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
class MenuFloverController extends BaseModuleController
{
    protected $moduleName = 'menuFlovers';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();

        $this->modelTitle = 'Цветы в меню';
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */

    protected function getIndexTableColumns(): TableColumns
    {
        $table = new TableColumns();


        $table->add(Text::make()->field('title')->title('Название'));
        $table->add(Text::make()->field('sort')->title('Сортировка'));





        return $table;
    }
    public function getForm(TwillModelContract $model): Form
    {

        return Form::make([
            Input::make()
                ->name('title')
                ->label('Название цветка')
                ->required(true),



            Input::make()
                ->name('sort')
                ->label('Сортировка')
                ->required(true),
        ]);
    }
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

       /* Schema::table('menu_flovers', function (Blueprint $table) {
            $table->string('title')->change();
        });*/


        return Form::make([
            Input::make()
                ->name('title')
                ->label('Название цветка'),

            Input::make()
                ->name('sort')
                ->label('Сортировка')

        ]);
    }
}
