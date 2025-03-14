<?php

namespace App\Services\Market;

use A17\Twill\Models\Role;
use App\Exceptions\LaravelJsonException;
use Illuminate\Support\Facades\Validator;
use JsonException;

class EmployerService {

    public function __construct($market) {
        $this->market = $market;
    }

    private $market;

    public function resolve($blocks) {
        $usersId = [];

        foreach ($blocks['blocks'] as $key => $block) {
            if (!$block['content'])
                continue;

            $employer = $block['content'];
            $employer['id'] = $block['id'];

            $usersId[] = $block['id'];

            $employer = Validator::validate(
                $employer,
                [
                    'id'          => 'numeric',
                    'phone'       => 'nullable',
                    'second_name' => 'nullable',
                    'last_name'   => 'nullable',
                    'name'        => 'required',
                    'email'       => 'required|email',
                    'role'        => 'required|in:manager,courier,florist',
                ]
            );

            if (!$this->exist($employer)) {

                $user = $this->register($employer);
                $employer['id'] = $user->id;
                $usersId[] = $user->id;

                $this->attach($employer);
            } else if ($this->isBelongsCurrentOrg($employer)) {
                $user = $this->attach($employer);
                $usersId[] = $user->id;
            } else {
                throw new LaravelJsonException(
                    json_encode(
                        [
                            'message' => __('Вы не можете использовать данный E-mail адрес ' . $employer['email'] . ''),
                            'variant' => 'error',
                        ]
                    )
                );
            }
        }

        $toDetachUsers = $this->market->employees()->wherePivotNotIn('user_id', $usersId)->get();


        foreach ($toDetachUsers as $user) {
            if ($this->isBelongsCurrentOrg($user->toArray())) {
                $this->detach($user);
            }
        }
    }

    public function register($employer) {
        dd($employer);
        $broker = app(\Illuminate\Auth\Passwords\PasswordBrokerManager::class);

        $roleCode = $employer['role'];
        unset($employer['role']);

        $employer['master_user_id'] = auth()->user()->id;
        $employer['published'] = false;

        $user = \A17\Twill\Models\User::create($employer);
        $user->role()->associate(Role::where('code', $roleCode)->first());
        $user->save();

        $user->sendWelcomeNotification(
            $broker->broker('twill_users')->getRepository()->create($user)
        );


        \Log::info('marketplace', ['Создан новый сотрудник ( № ' . $user->id . ') в магазине', $this->market->id]);

        return $user;
    }

    public function exist($employer) {
        return \A17\Twill\Models\User::where('id', $employer['id'])->orWhere('email', $employer['email'])->withTrashed()->exists();
    }

    public function attach($employer) {
        $user = \A17\Twill\Models\User::where('id', $employer['id'])->orWhere('email', $employer['email'])->withTrashed()->first();

        $userEmailObject = \A17\Twill\Models\User::where('email', $employer['email'])->withTrashed()->first();


        if ($user && $userEmailObject && $user->id !== $userEmailObject->id) {

            \Log::warning('Пользователь ' . auth()->user()->email . ' хотел воспользоваться E-mail адресом, который ему не принадлежит ' . $employer['email']);

            throw new LaravelJsonException(
                json_encode(
                    [
                        'message' => __('Вы не можете использовать данный E-mail адрес"' . $employer['email'] . '"'),
                        'variant' => 'error',
                    ]
                )
            );
        }

        if ($employer['role'] !== $user->role->code && $user->stores()->count() != 1) {
            throw new LaravelJsonException(
                json_encode(
                    [
                        'message' => __('У пользователя "' . $employer['email'] . '" может быть только 1 роль. Текущая роль - ( ' . $user->role->name . ' )'),
                        'variant' => 'error',
                    ]
                )
            );
        }


        $roleCode = $employer['role'];

        unset($employer['role'], $employer['id']);

        $employer['published'] = true;

        $user->update($employer);

        $user->role()->associate(Role::where('code', $roleCode)->first());

        if (!$user->stores()->where('market_id', $this->market->id)->exists()) {
            $user->stores()->attach($this->market->id);
        }

        $user->save();
        return $user;
    }


    function detachAll() {
        $toDetachUsers = $this->market->employees()->get();

        foreach ($toDetachUsers as $user) {
            if ($this->isBelongsCurrentOrg($user->toArray())) {
                $this->detach($user);
            }
        }
    }

    public function detach($employer) {
        $user = \A17\Twill\Models\User::where('id', $employer['id'])->orWhere('email', $employer['email'])->first();


        $user->stores()->detach($this->market->id);
        $user->save();

        if ($user->stores()->count() == 0) {
            $user->update(
                [
                    'published' => false,
                ]
            );
            $user->save();
        }

        \Log::info('marketplace', ['Сотрудник № ' . $user->email . ' удалён из магазина', $this->market->id]);
    }

    public function isBelongsCurrentOrg($employer) {
        $user = \A17\Twill\Models\User::where('id', $employer['id'])->orWhere('email', $employer['email'])->first();
        return $user->master_user_id == auth()->user()->id || \Gate::allows('impersonate');
    }
}
