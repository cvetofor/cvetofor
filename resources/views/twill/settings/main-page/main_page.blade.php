@twillBlockTitle('Главная страница')
@twillBlockIcon('text')
@twillBlockGroup('app')

<a17-fieldset title="Баннер" id="banner">
    <x-twill::repeater type="main-banner" name="banner" />
</a17-fieldset>

<a17-fieldset title="Поводы" id="tags">
    <x-twill::repeater type="arr" name="main_tags" />
</a17-fieldset>

<a17-fieldset title="Категории букетов" id="groupProductCategories">
    <x-twill::browser module-name="groupProductCategories" name="categories" note="Поочереди показывают товары"
        label="Категории букетов" :max="100" />
</a17-fieldset>
