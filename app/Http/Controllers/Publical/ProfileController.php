<?php

namespace App\Http\Controllers\Publical;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ChangeEmailNotification;

class ProfileController extends Controller {
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {
        return view('profile.index');
    }

    public function update(Request $request) {
        if ($request->has('phone')) {
            $request['phone'] = str_replace(['(', ')', '-', ' '], ['', '', '', ''], $request['phone']);
        }

        if ($request->has('password')) {
            $data = $this->validate($request, [
                'password' => 'required',
                'new_password' => 'confirmed|max:30|min:6|different:password',
            ], [
                'password.required' => 'Введите старый пароль',
                'new_password.max' => 'Пароль не должен быть больше :max символов',
                'new_password.min' => 'Пароль не должен быть меньше :min символов',
                'new_password.required' => 'Введите новый пароль',
                'new_password.confirmed' => 'Подтвердите новый пароль',
                'new_password.different' => 'Нельзя использовать одинаковые пароли',
            ]);

            if (Hash::check($request->password, auth()->user()->password)) {
                auth()->user()->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();

                $request->session()->flash('success', 'Пароль измёнен');
                return redirect()->back();
            } else {
                $request->session()->flash('error', 'Пароли не совпадают');
                return redirect()->back();
            }
        } else {

            $data = $this->validate($request, [
                'name' => 'required|string',
                'second_name' => '',
                'last_name' => 'required|string',
                'phone' => 'unique:users,phone,' . auth()->user()->id,
            ], [
                'name.required' => 'Имя обязательное поле',
                'last_name.required' => 'Фамилия обязательное поле',
                'phone.required_if' => 'Телефон обязателен если не указан Email',
                'email.unique' => 'Этот email уже привязан к другому аккаунту',
                'phone.unique' => 'Этот телефон уже привязан к другому аккаунту',
            ]);
        }

        auth()->user()->update($data);
        return back();
    }

    public function orders(Request $request) {
        $orders = auth()->user()->orders()->paginate();

        return view('profile.orders', compact('orders'));
    }

    public function review(Request $request) {
        $data = $this->validate(
            $request,
            [
                'order_id' => "exists:orders,id",
                'description' => 'required|string|max:1000'
            ]
        );
        $data['user_id'] = auth()->user()->profile->id;

        $order = Order::where('id', $data['order_id'])->where('parent_id', null)->first();
        if (!$order || $order->user->id !== auth()->user()->id) {
            return response()->json(
                [
                    'message' => 'Вы не можете обновить данные чужого заказа'
                ],
                403
            );
        }

        $review = Review::where('user_id', auth()->user()->id)->where('order_id', $data['order_id'])->first();

        if (!$review) {
            return ['status' => !!Review::create($data)];
        } else {
            $review->update(['description' => $data['description']]);
            $review->save();
            return ['status' => !!$review];
        }
    }

    public function changePassword() {
        return view('profile.changePassword');
    }

    public function changeEmail() {
        return view('profile.changeEmail');
    }

    public function changeEmailRequest(Request $request) {
        $data = $this->validate(
            $request,
            [
                'email' => 'required|email|unique:users,email',
            ],
            [
                'email.required_if' => 'Email обязателен если не указан Телефон',
                'email.unique' => 'Этот email уже привязан к другому аккаунту',
            ]
        );

        Notification::route('mail', $data['email'])
            ->notify(new ChangeEmailNotification(auth()->user(), $data['email']));

        return back()->with('success', 'Email изменен');
    }


    public function changeEmailConfirm(Request $request, User $user, string $email) {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $user->update([
            'email' => $email,
        ]);
        $user->save();

        return redirect()->route('profile.index');
    }
}
