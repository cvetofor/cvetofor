@php
$contentFieldsetLabel = 'Информация о магазине';
$canNotUpdateField = !\Gate::allows('is_owner');
@endphp
@extends('twill::layouts.form')

@section('contentFields')

<x-twill::input name="name" label="Название магазина" required="required" :maxlength="100" />

<x-twill::browser :disabled="$canNotUpdateField" module-name="users" name="user" label="Владелец магазина" :max="1" />

<x-twill::browser module-name="cities" name="city" label="Город" :max="1" />

<x-twill::input name="address" label="Адрес" required="required" :maxlength="1000" />

@formField('repeater', ['type' => 'additional_addresses', 'max' => 10])

<x-twill::input name="phone" required="required" label="Телефон" mask="+7 (999) 999 99 99" :maxlength="100" />

<x-twill::input name="email" label="E-mail" required="required" type="email" :maxlength="100"
    note="Сюда приходят письма о новом заказе" />


<x-twill::input prefix="₽" type="number" name="postcard_price" label='Стоимость открытки' :maxlength="10" />


<x-twill::input type="number" name="holidays_percent" prefix="%" max=100 min=0
    label="Процент увеличения стоимости товаров в праздничные дни" :maxlength="3" />


<x-twill::browser disabled="true" module-name="marketWorkTimes" name="work_times" label="Время работы магазина"
    :max="1" />

<x-twill::browser disabled="true" module-name="marketWorkTimes" name="delivery_times" label="Время доставки магазина"
    :max="1" />


@stop

@section('fieldsets')
<a17-fieldset title="Доставка" id="delivery">
    <h4>Существующие интервалы</h4>
    <!-- Заголовки колонок -->
    <div style="display: flex; gap: 10px; align-items: center; padding: 10px; font-weight: bold; border-bottom: 2px solid #ddd;">
        <div style="flex: 1;">С</div>
        <div style="flex: 1;">До</div>
        <div style="flex: 1;">Закрытие интервала</div>
        <div style="flex: 1;">Поведение</div>
        <div style="flex-shrink: 0;">Действия</div>
    </div>
    <!-- Существующие интервалы -->
    <div id="intervals-container" 
        data-update-url="{{ route('twill.markets.intervals.bulk-update') }}" 
        data-delete-url="{{ route('twill.markets.intervals.delete', ':id') }}"
      
        style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 10px;">
        
        @foreach ($item->intervals ?? [] as $interval)
        <div data-id="{{ $interval->id }}" style="display: flex; gap: 10px; align-items: center; padding: 10px; border: 1px solid #ddd; border-radius: 5px; min-width: 600px;">
            <input type="time" class="editable" data-field="start_time" value="{{ $interval->start_time }}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
            <input type="time" class="editable" data-field="end_time" value="{{ $interval->end_time }}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
            <input type="time" class="editable" data-field="close_time" value="{{ $interval->close_time }}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
            <select class="editable" data-field="close_time_behavior" style="flex: 1; min-width: 120px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="before" {{ $interval->close_time_behavior === 'before' ? 'selected' : '' }}>До начала</option>
                <option value="after" {{ $interval->close_time_behavior === 'after' ? 'selected' : '' }}>После начала</option>
            </select>
            <div style="flex-shrink: 0; min-width: 100px;">
                <button class="delete-interval" style="padding: 5px 10px; background-color: #ff4d4d; color: white; border: none; border-radius: 3px; cursor: pointer;">
                    Удалить
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <button id="save-intervals" disabled style="margin-top: 20px; padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 4px; cursor: pointer;">
        Сохранить изменения
    </button>

    <h4>Добавить новый интервал</h4>
    <div id="add-interval-container" 
        data-store-url="{{ route('twill.markets.intervals.store', $item->id) }}" 
        style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        <input type="time" id="start-time" required style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="С" value="00:00" />
        <input type="time" id="end-time" required style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="До" value="00:00" />
        <input type="time" id="close-time" required style="flex: 1; min-width: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" placeholder="Время закрытия" value="00:00" />
        <select id="close-time-behavior" required style="flex: 1; min-width: 120px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="before">До начала</option>
            <option value="after">После начала</option>
        </select>
        <div style="flex-shrink: 0; background-color: #4caf50; color: white; padding: 10px 15px; border-radius: 4px; cursor: pointer;" id="add-interval">
            Добавить
        </div>
    </div>

    <x-twill::input type="number" prefix="₽" name="price_i_dont_know_address"
        label="Стоимость доставки с неизвестного адреса" :maxlength="10" />


    <p>Для примера радиус можно посмотреть <a target="_blank" href="https://yandex.ru/maps/-/CLxuieC">тут</a>: </p>
    <details>
        <summary>Пример</summary>
        <div style="position:relative;overflow:hidden;"><a
                href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps"
                style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a><a
                href="https://yandex.ru/maps/213/moscow/?ll=37.828581%2C55.725241&mode=search&rl=37.620405%2C55.753991~-0.005257%2C0.090155&sll=37.620405%2C55.754047&text=55.754047%2C37.620405&utm_medium=mapframe&utm_source=maps&z=11.16"
                style="color:#eee;font-size:12px;position:absolute;top:14px;">Красная площадь — Яндекс Карты</a><iframe
                src="https://yandex.ru/map-widget/v1/?ll=37.828581%2C55.725241&mode=search&rl=37.620405%2C55.753991~-0.005257%2C0.090155&sll=37.620405%2C55.754047&text=55.754047%2C37.620405&z=11.16"
                height="400" frameborder="1" allowfullscreen="true" style="position:relative;width:100%"></iframe>
        </div>
    </details>

    @formField('repeater', ['type' => 'deliveries_radius', 'max' => 50])

</a17-fieldset>






<a17-fieldset title="Telegram уведомления" id="telegram">
    <x-twill::input name="telegram_bot_market_username" label="Username" note="@your_username" :maxlength="150" />
</a17-fieldset>

@if ((\Gate::allows('is_owner') || (\auth()->user()->role->code ?? false) === 'shop') && isset($item->id))
<a17-fieldset title="Сотрудники" id="employees">
    @formField('block_editor', [
    'blocks' => ['employers'],
    'label' => 'Добавить сотрудника',
    ])
</a17-fieldset>
@endif
@stop

@push('extra_js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const intervalsContainer = document.getElementById("intervals-container");
    const addIntervalButton = document.getElementById("add-interval");
    const saveIntervalsButton = document.getElementById("save-intervals");
    const storeUrl = document.getElementById("add-interval-container").dataset.storeUrl;
    const updateUrl = intervalsContainer.dataset.updateUrl;
    const deleteUrlTemplate = intervalsContainer.dataset.deleteUrl;
    const csrfToken = '{{ csrf_token() }}';

    let editedIntervals = {};

    // Валидация интервалов
    function validateInterval(startTime, endTime, existingIntervals = [], excludeId = null) {
        const errors = [];

        // Проверка: начальное время должно быть меньше конечного
        if (startTime >= endTime) {
            errors.push("Начальное время должно быть меньше конечного.");
        }

        // Проверка уникальности интервала
        const isDuplicate = existingIntervals.some(interval => {
            return interval.start_time === startTime && interval.end_time === endTime && interval.id !== excludeId;
        });

        if (isDuplicate) {
            errors.push("Интервал с таким временем уже существует.");
        }

        return errors;
    }

    // Отображение ошибок
    function displayErrors(input, errors) {
        if (errors.length > 0) {
            input.classList.add("error");
            input.setAttribute("title", errors.join("\n"));
        } else {
            input.classList.remove("error");
            input.removeAttribute("title");
        }
    }

    // Валидация всех интервалов
    function validateAllIntervals() {
        let hasErrors = false;
        const existingIntervals = Array.from(intervalsContainer.children).map(child => ({
            id: child.dataset.id,
            start_time: child.querySelector('[data-field="start_time"]').value,
            end_time: child.querySelector('[data-field="end_time"]').value,
        }));

        Array.from(intervalsContainer.children).forEach(child => {
            const startTime = child.querySelector('[data-field="start_time"]').value;
            const endTime = child.querySelector('[data-field="end_time"]').value;
            const intervalId = child.dataset.id;

            const errors = validateInterval(startTime, endTime, existingIntervals, intervalId);

            displayErrors(child.querySelector('[data-field="start_time"]'), errors);
            displayErrors(child.querySelector('[data-field="end_time"]'), errors);

            if (errors.length > 0) {
                hasErrors = true;
            }
        });

        updateButtonStates(hasErrors);
    }

    // Обновление состояния кнопок
    function updateButtonStates(hasErrors) {
        const hasChanges = Object.keys(editedIntervals).length > 0;

        saveIntervalsButton.disabled = hasErrors || !hasChanges;
        addIntervalButton.disabled = hasErrors;

        saveIntervalsButton.style.backgroundColor = saveIntervalsButton.disabled ? "#ccc" : "#4caf50";
        saveIntervalsButton.style.cursor = saveIntervalsButton.disabled ? "not-allowed" : "pointer";

        addIntervalButton.style.backgroundColor = addIntervalButton.disabled ? "#ccc" : "#4caf50";
        addIntervalButton.style.cursor = addIntervalButton.disabled ? "not-allowed" : "pointer";
    }

    // Добавление интервала
    async function addInterval(startTime, endTime, closeTime, closeTimeBehavior) {
        try {
            const response = await fetch(storeUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    start_time: startTime,
                    end_time: endTime,
                    close_time: closeTime,
                    close_time_behavior: closeTimeBehavior,
                }),
            });

            if (response.ok) {
                const data = await response.json();
                if (!data.success) throw new Error(data.message);

                const newInterval = data.interval;

                const newDiv = document.createElement("div");
                newDiv.setAttribute("data-id", newInterval.id);
                newDiv.style.cssText = "display: flex; gap: 10px; align-items: center; padding: 10px; border: 1px solid #ddd; border-radius: 5px; min-width: 600px;";

                 
                newDiv.innerHTML = `
                    <input type="time" class="editable" data-field="start_time" value="${newInterval.start_time}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
                    <input type="time" class="editable" data-field="end_time" value="${newInterval.end_time}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
                    <input type="time" class="editable" data-field="close_time" value="${newInterval.close_time}" style="flex: 1; min-width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;" />
                    <select class="editable" data-field="close_time_behavior" style="flex: 1; min-width: 120px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="before" ${newInterval.close_time_behavior === "before" ? "selected" : ""}>До начала</option>
                        <option value="after" ${newInterval.close_time_behavior === "after" ? "selected" : ""}>После начала</option>
                    </select>
                    <div style="flex-shrink: 0; min-width: 100px;">
                        <button class="delete-interval" style="padding: 5px 10px; background-color: #ff4d4d; color: white; border: none; border-radius: 3px; cursor: pointer;">Удалить</button>
                    </div>
                `;


                intervalsContainer.appendChild(newDiv);

                newDiv.querySelector(".delete-interval").addEventListener("click", () => {
                    deleteInterval(newInterval.id, newDiv);
                });

                validateAllIntervals();
                return true;
            } else {
                throw new Error("Ошибка при добавлении интервала.");
            }
        } catch (error) {
            console.error(error.message);
            alert(error.message);
            return false;
        }
    }

    // Удаление интервала
    async function deleteInterval(id, element) {
        try {
            const deleteUrl = deleteUrlTemplate.replace(":id", id);

            const response = await fetch(deleteUrl, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            });

            if (response.ok) {
                element.remove();
                validateAllIntervals();
                return true;
            } else {
                throw new Error("Ошибка при удалении интервала.");
            }
        } catch (error) {
            console.error(error.message);
            alert(error.message);
            return false;
        }
    }
    intervalsContainer.addEventListener("click", (event) => {
        if (event.target.classList.contains("delete-interval")) {
            const parentDiv = event.target.closest("div[data-id]");
            const intervalId = parentDiv.getAttribute("data-id");
            deleteInterval(intervalId, parentDiv);
        }
    });
    // Обработка изменений интервалов
    intervalsContainer.addEventListener("input", (event) => {
        if (event.target.classList.contains("editable")) {
            const parentDiv = event.target.closest("div[data-id]");
            const intervalId = parentDiv.dataset.id;
            const field = event.target.dataset.field;

            if (!editedIntervals[intervalId]) {
                editedIntervals[intervalId] = { id: intervalId };
            }
            editedIntervals[intervalId][field] = event.target.value;

            validateAllIntervals();
        }
    });

    // Сохранение изменений
    saveIntervalsButton.addEventListener("click", async () => {
        if (Object.keys(editedIntervals).length === 0) return;

        try {
            const response = await fetch(updateUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ intervals: Object.values(editedIntervals) }),
            });

            if (response.ok) {
                editedIntervals = {};
                validateAllIntervals();
            } else {
                throw new Error("Ошибка при сохранении изменений.");
            }
        } catch (error) {
            console.error(error.message);
            alert(error.message);
        }
    });

    // Добавление нового интервала
    addIntervalButton.addEventListener("click", async () => {
        const startTime = document.getElementById("start-time").value;
        const endTime = document.getElementById("end-time").value;
        const closeTime = document.getElementById("close-time").value;
        const closeTimeBehavior = document.getElementById("close-time-behavior").value;

        const errors = validateInterval(
            startTime,
            endTime,
            Array.from(intervalsContainer.children).map(child => ({
                id: child.dataset.id,
                start_time: child.querySelector('[data-field="start_time"]').value,
                end_time: child.querySelector('[data-field="end_time"]').value,
            }))
        );

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return;
        }

        await addInterval(startTime, endTime, closeTime, closeTimeBehavior);

        document.getElementById("start-time").value = "00:00";
        document.getElementById("end-time").value = "00:00";
        document.getElementById("close-time").value = "00:00";
        document.getElementById("close-time-behavior").value = "before";

        validateAllIntervals();
    });

    // Проверка интервалов при загрузке
    validateAllIntervals();
});


</script>
@endpush

@push('extra_css')
<style>
    .error {
    border-color: red !important;
    background-color: #ffe6e6;
}

button:disabled {
    background-color: #ccc !important;
    cursor: not-allowed !important;
}

</style>
@endpush