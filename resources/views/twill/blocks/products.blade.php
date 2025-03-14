@twillBlockTitle('Товары')
@twillRepeaterTitleField('__title', ['hidePrefix' => true])

@twillBlockIcon('add')
@twillBlockValidationRules(
    [
        'products' => 'required',
        'count' => 'required|numeric|min:1',
    ]
)


<a17-hidden-field name="__title" />

<x-twill::browser module-name="products" name="products" label="Товар" :max="1" />

<x-twill::browser label="Цвет" name="color" module-name="colors" connected-browser-field="products" note="Цвет" :required="true" :max="1" />


<x-twill::formConnectedFields field-name="products" :is-browser="true" :keep-alive="true" :renderForBlocks=true>

    <x-twill::input required type="number" name="count" label="Количество" min="1" />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields field-name="__is_category_avalible" :field-values="false" :keep-alive="true" :renderForBlocks=true>
    <p style="color:orange; margin-top:10px">* Данная категория товаров не доступна для просмотра и изменения покупателям</p>
</x-twill::formConnectedFields>
