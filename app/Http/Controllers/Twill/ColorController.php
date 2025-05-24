<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ColorController extends BaseModuleController
{
    protected $moduleName = 'colors';

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->modelTitle = 'Цвет';
        $this->disablePermalink();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('data_rgb')->label('RGB')
        );

        return $form;
    }

    public function getBrowserData($prependScope = []): array
    {
        $data = parent::getBrowserData($prependScope);

        if ($this->request->has('connectedBrowserIds')) {

            $request = json_decode($this->request->get('connectedBrowserIds'));
            if (is_array($request)) {
                $productId = (int) $request[0];

                if (is_numeric($productId)) {
                    $repository = new ProductRepository(new Product);
                    $product = $repository->getById($productId);
                    $colors = $product->getRelated('colors');

                    foreach ($data['data'] as $key => $color) {
                        if (! in_array($color['id'], $colors->pluck('id')->toArray())) {
                            unset($data['data'][$key]);
                        }

                        if (! auth()->user()->can('edit-module', 'colors')) {
                            $data['data'][$key]['edit'] = false;
                        }

                    }
                }
            }
        }
        $data['data'] = array_values($data['data']);

        return $data;
    }
}
