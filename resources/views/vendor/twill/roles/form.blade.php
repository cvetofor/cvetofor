@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Permissions',
])

@section('contentFields')

    <x-twill::input
        name="code"
        label="Code"
        maxlength="20"
        disabled="disabled"
    />

    <x-twill::fieldRows title="Основные настройки">
        <x-twill::checkbox
            name="edit-settings"
            label="Редактирование полей настроек"
        />

        <x-twill::checkbox
            name="edit-users"
            label="Управление пользователями"
        />

        <x-twill::checkbox
            name="edit-user-roles"
            label="Управление ролями"
        />

        <x-twill::checkbox
            name="edit-user-groups"
            label="Управление группами"
        />

        <x-twill::checkbox
            name="access-media-library"
            label="Просмотр медиа"
        />

        <x-twill::checkbox
            name="edit-media-library"
            label="Загружать медиа"
        />
    </x-twill::fieldRows>

    <x-twill::fieldRows title="Разрешения">
        <x-twill::checkbox
            name="manage-modules"
            label="Управление всеми модулями"
        />

        <x-twill::formConnectedFields
            field-name="manage-modules"
            :field-values="false"
        >
            @foreach($permission_modules as $module_name => $module_items)
                <x-twill::select
                    :name="'module_' . $module_name . '_permissions'"
                    :label="ucfirst(__('permissions.'.$module_name)) . ' '"
                    placeholder="Выберите разрешения"
                    :options="array_merge([
                            [
                                'value' => 'none',
                                'label' => 'Отсуствуют'
                            ],
                            [
                                'value' => 'view-module',
                                'label' => 'Просмотр ' . __('permissions.'.$module_name)
                            ],
                            [
                                'value' => 'edit-module',
                                'label' => 'Редактирование ' . __('permissions.'.$module_name)
                            ]
                        ],
                        (\A17\Twill\Facades\TwillPermissions::levelIs(\A17\Twill\Enums\PermissionLevel::LEVEL_ROLE_GROUP_ITEM) ? [['value' => 'manage-module', 'label' => 'Управление ' . __('permissions.'.$moduleName) ]] : []))"
                />
            @endforeach
        </x-twill::formConnectedFields>
    </x-twill::fieldRows>

    <x-twill::fieldRows title="Groups">
        <x-twill::checkbox
            name="in_everyone_group"
            label="Включить группу 'Everyone'"
        />
    </x-twill::fieldRows>
@stop
