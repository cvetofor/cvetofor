@twillBlockTitle('Сотрудничество')

@twillBlockIcon('b-color')


@twillBlockValidationRules(
    [
        // 'products' => 'required',
        // 'count' => 'required|numeric|min:1',
    ]
)


<x-twill::input type="text" name="title" label="Заголовок" />

<x-twill::medias
    name="image"
    label="Лицо"
/>
<x-twill::input type="text"
    name="face_name"
    label="ФИО"
/>
<x-twill::input type="text" name="job_title" label="Должность" />
<x-twill::input type="text" name="phone" label="Телефон" />
<x-twill::input type="text" name="email" label="E-mail" />
<x-twill::input type="text" name="single_phone" label="Единый номер" />

<a17-fieldset title="Социальные сети">
    <x-twill::input name="vk" label="Ссылка ВК" />

    <x-twill::input name="whatsapp" label="Ссылка whatsapp" />

    <x-twill::input name="telegram" label="Ссылка telegram" />
</a17-fieldset>

