<?php
    /*
    |--------------------------------------------------------------------------
    | 5 Steps to Contribute a New Twill Localization at Ease
    |--------------------------------------------------------------------------
    | 1. Find the "lang.csv" under "lang" directory.
    | 2. Import the csv file into a blank Google Sheet.
    | 3. Each column is a language, enter the translation for a column. (tips: feel free to freeze rows and columns).
    | 4. Download the Google Sheet as CSV, replace the original "lang/lang.csv" with the new one.
    | 5. Run the command "php artisan twill:lang" to sync all lang files.
    */


return [
    'auth' => [
        'back-to-login' => 'Вернуться к входу',
        'choose-password' => 'Выберите пароль',
        'email' => 'Электронная почта',
        'forgot-password' => 'Забыли пароль',
        'login' => 'Войти',
        'login-title' => 'Войти',
        'oauth-link-title' => 'Повторно введите свой пароль, чтобы связать :provider с вашей учетной записью',
        'otp' => 'Одноразовый пароль',
        'password' => 'Пароль',
        'password-confirmation' => 'Подтвердить пароль',
        'reset-password' => 'Сбросить пароль',
        'reset-send' => 'Отправить ссылку для сброса пароля',
        'verify-login' => 'Подтвердить логин',
        'auth-causer' => 'Аутентификация'
    ],
    'buckets' => [
        'intro' => 'Что бы вы хотели показать сегодня?',
        'none-available' => 'Нет доступных элементов.',
        'none-featured' => 'Нет представленных элементов.',
        'publish' => 'Опубликовать',
        'source-title' => 'Доступные элементы',
    ],
    'dashboard' => [
        'all-activity' => 'Все действия',
        'create-new' => 'Создать новый',
        'empty-message' => 'У вас пока нет активности.',
        'my-activity' => 'Моя активность',
        'my-drafts' => 'Мои черновики',
        'search-placeholder' => 'Искать везде...',
        'statitics' => 'Статистика',
        'search' => [
            'loading' => 'Загрузка…',
            'no-result' => 'Результаты не найдены.',
            'last-edit' => 'Последнее редактирование',
        ],
        'activities' => [
            'created' => 'Создано',
            'updated' => 'Обновлено',
            'unpublished' => 'Неопубликованные',
            'published' => 'Опубликовано',
            'featured' => 'Избранное',
            'unfeatured' => 'Неизвестный',
            'restored' => 'Восстановлено',
            'deleted' => 'Удалено',
            'login' => 'Действие входа',
            'logout' => 'Выход из системы'
        ],
        'activity-row' => [
            'edit' => 'Редактировать',
            'view-permalink' => 'Просмотреть постоянную ссылку',
            'by' => 'По',
        ],
        'unknown-author' => 'Неизвестный',
    ],
    'dialog' => [
        'cancel' => 'Отмена',
        'ok' => 'Хорошо',
        'title' => 'В корзину',
    ],
    'editor' => [
        'cancel' => 'Отмена',
        'delete' => 'Удалить',
        'done' => 'Готово',
        'title' => 'Редактор контента',
    ],
    'emails' => [
        'all-rights-reserved' => 'Все права защищены.',
        'hello' => 'Привет!',
        'problems' => 'Если у вас возникли проблемы с нажатием кнопки ":actionText", скопируйте и вставьте приведенный ниже URL-адрес в свой веб-браузер: [:url](:url)',
        'regards' => 'С уважением,',
    ],
    'fields' => [
        'block-editor' => [
            'add-content' => 'Добавить',
            'collapse-all' => 'Свернуть все',
            'create-another' => 'Создать еще',
            'delete' => 'Удалить',
            'expand-all' => 'Развернуть все',
            'loading' => 'Загрузка',
            'open-in-editor' => 'Открыть в редакторе',
            'preview' => 'Предварительный просмотр',
            'add-item' => 'Добавить',
            'clone-block' => 'Клонировать блок',
            'select-existing' => 'Выбрать существующий',
        ],
        'browser' => [
            'add-label' => 'Добавить',
            'attach' => 'Прикрепить',
        ],
        'files' => [
            'add-label' => 'Добавить',
            'attach' => 'Прикрепить',
        ],
        'generic' => [
            'switch-language' => 'Переключить язык',
        ],
        'map' => [
            'hide' => 'Скрыть&nbsp;карту',
            'show' => 'Показать&nbsp;карту',
        ],
        'medias' => [
            'btn-label' => 'Прикрепить изображение',
            'crop' => 'Обрезать',
            'crop-edit' => 'Редактировать обрезку изображения',
            'crop-list' => 'Культура',
            'crop-save' => 'Обновить',
            'delete' => 'Удалить',
            'download' => 'Скачать',
            'edit-close' => 'Закрыть информацию',
            'edit-info' => 'Редактировать информацию',
            'original-dimensions' => 'Исходный',
            'alt-text' => 'alt текст',
            'caption' => 'Подпись',
            'video-url' => 'URL-адрес видео (необязательно)',
        ],
    ],
    'filter' => [
        'apply-btn' => 'Применить',
        'clear-btn' => 'Очистить',
        'search-placeholder' => 'Поиск',
        'toggle-label' => 'Фильтр',
    ],
    'footer' => [
        'version' => 'Версия',
    ],
    'form' => [
        'options' => 'Опции',
        'content' => 'Контент',
        'dialogs' => [
            'delete' => [
                'confirm' => 'Удалить',
                'confirmation' => 'Вы уверены?<br />Это изменение нельзя отменить.',
                'delete-content' => 'Удалить содержимое',
                'title' => 'Удалить содержимое',
            ],
        ],
        'editor' => 'Редактор',
    ],
    'lang-manager' => [
        'published' => 'Активный',
    ],
    'lang-switcher' => [
        'edit-in' => 'Редактировать в',
    ],
    'listing' => [
        'add-new-button' => 'Добавить',
        'bulk-actions' => 'Массовые действия',
        'bulk-clear' => 'Очистить',
        'columns' => [
            'featured' => 'Избранное',
            'name' => 'Имя',
            'published' => 'Опубликовано',
            'show' => 'Показать',
            'thumbnail' => 'Миниатюра',
        ],
        'dialogs' => [
            'delete' => [
                'confirm' => 'Удалить',
                'disclaimer' => 'Элемент не будет удален, а будет перемещен в корзину.',
                'move-to-trash' => 'Переместить в корзину',
                'title' => 'Удалить элемент',
            ],
            'destroy' => [
                'confirm' => 'Уничтожить',
                'destroy-permanently' => 'Уничтожить безвозвратно',
                'disclaimer' => 'Элемент больше нельзя будет восстановить.',
                'title' => 'Уничтожить предмет',
            ],
        ],
        'dropdown' => [
            'delete' => 'Удалить',
            'destroy' => 'Уничтожить',
            'duplicate' => 'Дублировать',
            'edit' => 'Открыть',
            'publish' => 'Опубликовать',
            'feature' => 'Функция',
            'restore' => 'Восстановить',
            'unfeature' => 'Нехарактерный',
            'unpublish' => 'Недоступно',
        ],
        'filter' => [
            'no' => 'Нет',
            'yes' => 'Да',
            'not-set' => 'Без значения',
            'all-items' => 'Все элементы',
            'draft' => 'Нет в наличии',
            'mine' => 'Мои',
            'published' => 'Опубликовано',
            'trash' => 'Корзина',
        ],
        'filters' => [
            'all-label' => 'Все',
        ],
        'languages' => 'Языки',
        'listing-empty-message' => 'Ничего нет',
        'paginate' => [
            'rows-per-page' => 'Строек на странице:',
        ],
        'bulk-selected-item' => 'Элемент выбран',
        'bulk-selected-items' => 'Выбранные элементы',
        'reorder' => [
            'success' => ':ModelTitle порядок изменен!',
            'error' => ':ModelTitle порядок modelTitle не был изменен. Произошло что-то не так!',
        ],
        'restore' => [
            'success' => ':modelTitle восстановлено!',
            'error' => ':modelTitle не был восстановлен. Произошло что-то не так!',
        ],
        'bulk-restore' => [
            'success' => ':modelTitle восстановлены!',
            'error' => ':modelTitle не были восстановлены. Произошло что-то не так!',
        ],
        'force-delete' => [
            'success' => ':modelTitle уничтожено!',
            'error' => ':modelTitle не был уничтожен. Произошло что-то не так!',
        ],
        'bulk-force-delete' => [
            'success' => ':modelTitle уничтожены!',
            'error' => ':modelTitle не были уничтожены. Произошло что-то не так!',
        ],
        'delete' => [
            'success' => ':modelTitle в корзине!',
            'error' => ':modelTitle не был перемещен в корзину. Произошло что-то не так!',
        ],
        'bulk-delete' => [
            'success' => ':modelTitle перемещены в корзину!',
            'error' => ':modelTitle не были перемещены в корзину. Произошло что-то не так!',
        ],
        'duplicate' => [
            'success' => ':modelTitle дублируется с Success!',
            'error' => ':modelTitle не дублируется. Произошло что-то не так!',
        ],
        'publish' => [
            'unpublished' => ':modelTitle неопубликовано!',
            'published' => ':modelTitle опубликовано!',
            'error' => ':modelTitle не был опубликован. Произошло что-то не так!',
        ],
        'featured' => [
            'unfeatured' => ':modelTitle unfeatured!',
            'featured' => ':modelTitle признакам!',
            'error' => ':modelTitle не был показан. Произошло что-то не так!',
        ],
        'bulk-featured' => [
            'unfeatured' => ':modelTitle не представлены!',
            'featured' => ':modelTitle избранные элементы!',
            'error' => ':modelTitle не были показаны. Произошло что-то не так!',
        ],
        'bulk-publish' => [
            'unpublished' => ':modelTitle не опубликованы!',
            'published' => ':modelTitle опубликованы!',
            'error' => ':modelTitle не были опубликованы. Произошло что-то не так!',
        ],
    ],
    'main' => [
        'create' => 'Создать',
        'draft' => 'Нет в наличии',
        'published' => 'Активный',
        'title' => 'Название',
        'update' => 'Обновить',
    ],
    'media-library' => [
        'files' => 'Файлы',
        'filter-select-label' => 'Фильтровать по тегу',
        'images' => 'Изображения',
        'insert' => 'Вставить',
        'sidebar' => [
            'alt-text' => 'alt текст',
            'caption' => 'Подпись',
            'clear' => 'Очистить',
            'dimensions' => 'Размеры',
            'empty-text' => 'Файл не выбран',
            'files-selected' => 'Выбранные файлы',
            'tags' => 'Теги',
        ],
        'title' => 'Медиатека',
        'update' => 'Обновить',
        'unused-filter-label' => 'Показывать только неиспользуемые',
        'no-tags-found' => 'Извините, теги не найдены.',
        'dialogs' => [
            'delete' => [
                'delete-media-title' => 'Удалить медиа',
                'delete-media-desc' => 'Вы уверены?<br />Это изменение нельзя отменить.',
                'delete-media-confirm' => 'Удалить',
                'title' => 'Вы уверены?',
                'allow-delete-multiple-medias' => 'Некоторые файлы используются и не могут быть удалены. Вы хотите удалить остальные?',
                'allow-delete-one-media' => 'Этот файл используется и не может быть удален. Вы хотите удалить остальные?',
                'dont-allow-delete-multiple-medias' => 'Эти файлы используются и не могут быть удалены.',
                'dont-allow-delete-one-media' => 'Этот файл используется и не может быть удален.',
            ],
            'replace' => [
                'replace-media-title' => 'Заменить медиа',
                'replace-media-desc' => 'Вы уверены?<br />Это изменение нельзя отменить.',
                'replace-media-confirm' => 'Заменить',
            ],
        ],
        'types' => [
            'single' => [
                'image' => 'Изображение',
                'video' => 'Видео',
                'file' => 'Файл',
            ],
            'multiple' => [
                'image' => 'Изображения',
                'video' => 'Видео',
                'file' => 'Файлы',
            ],
        ],
    ],
    'modal' => [
        'create' => [
            'button' => 'Создать',
            'create-another' => 'Создать и добавить еще',
            'title' => 'Добавить',
        ],
        'permalink-field' => 'Постоянная ссылка',
        'title-field' => 'Заголовок',
        'update' => [
            'button' => 'Обновить',
            'title' => 'Обновить',
        ],
        'done' => [
            'button' => 'Готово',
        ],
    ],
    'nav' => [
        'admin' => 'Админ',
        'cms-users' => 'Пользователи',
        'logout' => 'Выйти',
        'media-library' => 'Медиатека',
        'settings' => 'Настройки',
        'close-menu' => 'Закрыть меню',
        'profile' => 'Профиль',
        'open-live-site' => 'Открыть живой сайт',
    ],
    'notifications' => [
        'reset' => [
            'action' => 'Сбросить пароль',
            'content' => 'Вы получили это письмо, потому что мы получили сброс пароля. Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.',
            'subject' => ':appName | Сброс пароля',
        ],
        'welcome' => [
            'action' => 'Выберите свой пароль',
            'content' => 'Вы получили это письмо, потому что для вас была создана учетная запись :name.',
            'title' => 'Добро пожаловать',
            'subject' => ':appName | Добро пожаловать',
        ],
    ],
    'overlay' => [
        'close' => 'Закрыть',
    ],
    'previewer' => [
        'compare-view' => 'Сравнить вид',
        'current-revision' => 'Текущая',
        'editor' => 'Редактор',
        'last-edit' => 'Последнее редактирование',
        'past-revision' => 'Прошлое',
        'restore' => 'Восстановить',
        'revision-history' => 'История изменений',
        'single-view' => 'Одно представление',
        'title' => 'Предварительный просмотр изменений',
        'unsaved' => 'Предварительный просмотр несохраненных изменений',
        'drag-and-drop' => 'Перетащите содержимое из левой панели навигации',
    ],
    'publisher' => [
        'cancel' => 'Отмена',
        'current' => 'Текущий',
        'end-date' => 'Дата окончания',
        'immediate' => 'Немедленно',
        'languages' => 'Языки',
        'languages-published' => 'Активный',
        'last-edit' => 'Последнее редактирование',
        'preview' => 'Предварительный просмотр изменений',
        'publish' => 'Опубликовать',
        'publish-close' => 'Опубликовать и закрыть',
        'publish-new' => 'Опубликовать и создать новый',
        'published-on' => 'Опубликовано',
        'restore-draft' => 'Восстановить',
        'restore-draft-close' => 'Восстановить и закрыть',
        'restore-draft-new' => 'Восстановить и создать новый',
        'restore-live' => 'Восстановить как опубликовано',
        'restore-live-close' => 'Восстановить как опубликованное и закрыть',
        'restore-live-new' => 'Восстановить как опубликованное и создать новое',
        'restore-message' => 'В настоящее время вы редактируете более старую версию этого контента (сохраненную пользователем :user :date). При необходимости внесите изменения и нажмите «Восстановить», чтобы сохранить новую версию.',
        'restore-success' => 'Редакция восстановлена.',
        'draft-revision' => 'Сохранить',
        'draft-revision-close' => 'Сохранить и закрыть',
        'draft-revision-new' => 'Сохранить как черновик версии и создать новую',
        'draft-revisions-available' => 'В настоящее время вы просматриваете опубликованную версию этого контента. Доступны новые черновые версии.',
        'editing-draft-revision' => 'В настоящее время вы редактируете черновую версию этого контента. При необходимости внесите изменения и нажмите «Сохранить как редакцию» или «Опубликовать».',
        'revisions' => 'История',
        'save' => 'Сохранить',
        'save-close' => 'Сохранить и закрыть',
        'save-new' => 'Сохранить и создать новый',
        'save-success' => 'Успешно!',
        'start-date' => 'Дата начала',
        'switcher-title' => 'Статус',
        'update' => 'Обновить',
        'update-close' => 'Обновить и закрыть',
        'update-new' => 'Обновить и создать новый',
        'parent-page' => 'Родительская страница',
        'review-status' => 'Статус проверки',
        'visibility' => 'Видимость',
        'scheduled' => 'Запланировано',
        'expired' => 'Истекший',
        'unsaved-changes' => 'Есть несохраненные изменения',
    ],
    'select' => [
        'empty-text' => 'Извините, нет подходящих вариантов.',
    ],
    'uploader' => [
        'dropzone-text' => 'Или перетащите сюда новые файлы',
        'upload-btn-label' => 'Выбрать',
    ],
    'user-management' => [
        '2fa' => 'Двухфакторная аутентификация',
        '2fa-description' => 'Пожалуйста, отсканируйте этот QR-код с помощью приложения, совместимого с Google Authenticator, и введите одноразовый пароль ниже перед отправкой. <a href=":link" target="_blank" rel="noopener">Я.Ключ</a>.',
        '2fa-disable' => 'Введите одноразовый пароль, чтобы отключить двухфакторную аутентификацию',
        'active' => 'Активный',
        'cancel' => 'Отмена',
        'content-fieldset-label' => 'Учетная запись',
        'description' => 'Описание',
        'disabled' => 'Отключено',
        'edit-modal-title' => 'Изменить имя пользователя',
        'email' => 'Электронная почта',
        'enable-user' => 'Включить пользователя',
        'enable-user-and-close' => 'Включить пользователя и закрыть',
        'enable-user-and-create-new' => 'Включить пользователя и создать нового',
        'enabled' => 'Включено',
        'language' => 'Язык',
        'language-placeholder' => 'Выберите язык',
        'name' => 'Имя',
        'otp' => 'Одноразовый пароль',
        'profile-image' => 'Изображение профиля',
        'role' => 'Роль',
        'role-placeholder' => 'Выберите роль',
        'title' => 'Название',
        'trash' => 'В корзине',
        'update' => 'Обновить',
        'update-and-close' => 'Обновить и закрыть',
        'update-and-create-new' => 'Обновить и создать новый',
        'update-disabled-and-close' => 'Обновление отключено и закрыто',
        'update-disabled-user' => 'Обновить отключенного пользователя',
        'update-disabled-user-and-create-new' => 'Обновить отключенного пользователя и создать нового',
        'user-image' => 'Изображение',
        'users' => 'Пользователи',
        'force-2fa-disable' => 'Отключить 2FA',
        'force-2fa-disable-description' => 'Введите текст, показанный в поле, чтобы отключить 2FA для этого пользователя',
        'force-2fa-disable-challenge' => 'Отключить 2FA для :user',
        'pending' => 'В ожидании',
        'activation-pending' => 'В ожидании активации',
    ],
    'settings' => [
        'update' => 'Обновить',
        'cancel' => 'Отмена',
        'fieldset-label' => 'Изменить настройки',
    ],
    'permissions' => [
        'groups' => [
            'title' => 'Группы',
            'published' => 'Включено',
            'draft' => 'Отключено',
        ],
        'roles' => [
            'title' => 'Роли',
            'published' => 'Включено',
            'draft' => 'Отключено',
        ],
    ]
];
