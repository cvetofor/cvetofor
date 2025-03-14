<h1 class="header__title">
    <a href={{ config('twill.enabled.dashboard') ? route('twill.dashboard') : '#' }} style="font-weight: bold;" @if(\App\Models\Hollyday::isHollyDays()) title="Праздничные дни" @endif>
        {{ config('app.name') }} @if(\App\Models\Hollyday::isHollyDays()) 🎉 @endif
    </a>
</h1>

<style>
    .vs__dropdown-menu {
        width: auto;
    }

    button.button.button--green {
        text-decoration: none;
        padding: 6px;
        background: #1a8f36;
        border: none;
        color: white
    }

    button.button.button--red {
        text-decoration: none;
        padding: 6px;
        background: #c7a2a2;
        border: none;
        color: white
    }

    button.button.button--gray {
        text-decoration: none;
        padding: 6px;
        background: #8a8a8a;
        border: none;
        color: white
    }

    button.button.button:hover {
        opacity: 0.8;
    }
</style>

<style type="text/css">
    .hovergallery {
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
    }

    .hovergallery img {
        max-width: 250px;
        max-height: 250px;
        -webkit-transform: scale(0.8);
        /*Webkit: уменьшаем размер до 0.8*/
        -moz-transform: scale(0.8);
        /*Mozilla: масштабирование*/
        -o-transform: scale(0.8);
        /*Opera: масштабирование*/
        -webkit-transition-duration: 0.5s;
        /*Webkit: длительность анимации*/
        -moz-transition-duration: 0.5s;
        /*Mozilla: длительность анимации*/
        -o-transition-duration: 0.5s;
        /*Opera: длительность анимации*/
        opacity: 0.7;
        /*Начальная прозрачность изображений*/
        margin: 0 10px 5px 0;
        /*Интервалы между изображениями*/
    }

    .hovergallery img:hover {
        -webkit-transform: scale(1.5);
        /*Webkit: увеличиваем размер до 1.2x*/
        -moz-transform: scale(1.5);
        /*Mozilla: масштабирование*/
        -o-transform: scale(1.5);
        /*Opera: масштабирование*/
        box-shadow: 0px 0px 30px gray;
        /*CSS3 тени: 30px размытая тень вокруг всего изображения*/
        -webkit-box-shadow: 0px 0px 30px gray;
        /*Webkit: тени*/
        -moz-box-shadow: 0px 0px 30px gray;
        /*Mozilla: тени*/
        opacity: 1;
        z-index: 999;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.querySelector('[href="#import"]');

        if(button)
        {
            button.addEventListener('click', function() {
            var input = document.createElement('input');
            input.type = 'file';
            input.name = 'import';

            input.onchange = e => {
                var file = e.target.files[0];
                if (file) {
                    button.disabled = true;
                    button.text = 'Загружается...';

                    let formData = new FormData();

                    formData.append("import", file);

                    fetch('{{ route('twill.products.import') }}', {
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    }).then((result) => {
                        if (!result.ok) {
                            window.TWILL.vm.$store.commit('setNotification', {
                                message:  'Формат не поддерживается, требуется csv',
                                variant: "error",
                            });
                        } else {
                            window.TWILL.vm.$store.commit('setNotification', {
                                message: 'Успешно! Требуется некоторое время, пока цены загрузятся',
                                variant: "success",
                            })
                        }
                    }).catch((err) => {
                        alert(err);
                    }).finally((err) => {
                        button.text = 'Загрузить прайс';
                    });
                }
            }

            input.click();

        })
        }
    })
</script>
