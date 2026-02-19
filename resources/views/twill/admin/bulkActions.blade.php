<div style="margin-bottom: 15px; display: flex; align-items: center;">
    <select id="myBulkSelect" style="margin-right: 10px; padding: 5px;">
        <option value="">Выберите действие</option>
        <option value="assignCategory">Назначить категорию</option>
        <option value="publish">Опубликовать</option>
        <option value="addReason">Добавить повод</option>
        <option value="removeReason">Удалить повод</option>
        <option value="calculatePrice">Рассчитать цену</option>
    </select>
    <button id="myBulkApply" class="button">Применить</button>
</div>

<script>
    document.getElementById("myBulkApply").addEventListener("click", function() {
        var action = document.getElementById("myBulkSelect").value;
        if (!action) { alert("Выберите действие"); return; }
        alert("Вы выбрали: " + action);
        // Здесь можно отправить AJAX на сервер и обработать выбранное действие
    });
</script>
