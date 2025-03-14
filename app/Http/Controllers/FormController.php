<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller {
    public function form(Request $request) {
        $data = $this->validate($request, [
            'fio' => 'string|required',
            'phone' => 'required|min:11',
            'email' => 'email',
            'comment' => 'required|max:500',
        ]);

        $data['title'] = $data['fio'];
        $data['ip'] = $request->ip();
        $data['page'] = $request->fullUrl();
        $data['city_id'] =  request()->cookie('city_id');
        $data['published'] =  true;

        return Form::create($data);
    }
}
