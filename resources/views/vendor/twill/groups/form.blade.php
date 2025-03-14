@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name="description"
        label="Описание"
        :maxlength="250"
        placeholder="Введите описание группы"
        type="textarea"
        :rows="3"
    />

    <x-twill::browser
        module-name="users"
        name="users"
        label="Пользователи"
    />

    @if(\A17\Twill\Facades\TwillPermissions::levelIs(\A17\Twill\Enums\PermissionLevel::LEVEL_ROLE_GROUP))
        <x-twill::fieldRows title="Разрешения">
            <x-twill::checkbox
                name="manage-modules"
                label="Управление модулями"
            />

            <x-twill::formConnectedFields field-name="manage-modules"
                                          :fieldValues="false"
            >
                @foreach($permissionModules as $moduleName => $moduleItems)
                    <x-twill::select
                        :name="'module_' . $moduleName . '_permissions'"
                        :label="ucfirst( __('permissions.'.$moduleName)) . ' '"
                        placeholder="Выберите разрешения"
                        :options="[
                            [
                                'value' => 'none',
                                'label' => 'Отсуствуют'
                            ],
                            [
                                'value' => 'view-module',
                                'label' => 'Просмотр ' . __('permissions.'.$moduleName)
                            ],
                            [
                                'value' => 'edit-module',
                                'label' => 'Редактирование ' .  __('permissions.'.$moduleName)
                            ]
                        ]"
                    />
                @endforeach
            </x-twill::formConnectedFields>
        </x-twill::fieldRows>
    @endif

    @if(config('twill.support_subdomain_admin_routing'))
        <x-twill::fieldRows title="Subdomain access">
            @foreach(config('twill.app_names') as $subdomain => $subdomainTitle)
                <x-twill::checkbox
                    :name="'subdomain_access_' . $subdomain"
                    :label="$subdomainTitle"
                />
            @endforeach
        </x-twill::fieldRows>
    @endif
@stop

@if(\A17\Twill\Facades\TwillPermissions::levelIs(\A17\Twill\Enums\PermissionLevel::LEVEL_ROLE_GROUP_ITEM))
    @can('edit-user-groups')
        @section('fieldsets')
            @foreach($permissionModules as $moduleName => $moduleItems)
                <a17-fieldset title='{{ ucfirst( __('permissions.'.$moduleName)) . " Permissions"}}' id='{{ $moduleName }}'>
                    <x-twill::select-permissions
                        :items-in-selects-tables="$moduleItems"
                        label-key="title"
                        :name-pattern="$moduleName . '_%id%_permission'"
                    />
                </a17-fieldset>
            @endforeach
        @stop
    @endcan
@endif
