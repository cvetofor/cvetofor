<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class StockRequest extends Request
{
    public function rulesForCreate()
    {
        $rules  = [
            'title' => 'required|max:200',
            'code' => 'required|numeric|unique:stocks,code',
            'quantity' => 'required|numeric|max:9999',
        ];

        if (!empty(request('percent'))) {
            $rules['percent'] = 'numeric|max:99|min:0';
        }

        if (empty(request('price')) && !empty(request('percent'))) {
            $rules['percent'] .= "|required";
        }

        if (!empty(request('price'))) {
            $rules['price'] = 'numeric|max:100000|min:0';
        }
        if (empty(request('percent')) && !empty(request('price'))) {
            $rules['price'] .= "|required";
        }

        if (
            empty(request('price')) &&
            empty(request('percent'))
        ) {
            $rules['percent'] = "required_without:price";
            $rules['price'] = "required_without:percent";
        }
    }

    public function rulesForUpdate()
    {

        $rules  = [
            'title' => 'required|max:200',
            'code' => 'required|numeric|unique:stocks,code,' . $this->stock,
            'quantity' => 'required|numeric|max:9999',
        ];

        if (!empty(request('percent'))) {
            $rules['percent'] = 'numeric|max:99|min:0';
        }

        if (empty(request('price')) && !empty(request('percent'))) {
            $rules['percent'] .= "|required";
        }

        if (!empty(request('price'))) {
            $rules['price'] = 'numeric|max:100000|min:0';
        }
        if (empty(request('percent')) && !empty(request('price'))) {
            $rules['price'] .= "|required";
        }

        if (
            empty(request('price')) &&
            empty(request('percent'))
        ) {
            $rules['percent'] = "required_without:price";
            $rules['price'] = "required_without:percent";
        }

        return $rules;
    }
}
