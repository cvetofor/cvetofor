@twillRepeaterTitle('Главный баннер')
@twillRepeaterTitleField('title', ['hidePrefix' => true])
@twillRepeaterTrigger('Добавить')
@twillRepeaterGroup('banner')

<x-twill::medias name="image" label="Изображение" :max="1" />

<x-twill::checkbox
    name="view_city"
    label="Вставить название города"
/>

@formField('input', [
    'name' => 'title',
    'label' => 'Название',
    'required' => true,
])


@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Описание',
])
