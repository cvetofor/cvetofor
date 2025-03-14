@formField('input', [
    'name' => 'title',
    'label' => 'Название',
    'required' => true,
])

@push('extra_js_head')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let query = document.querySelectorAll('[data-product-price]');

            Array.prototype.map.call(query, e => e.addEventListener('change', function() {
                let price = this.value;
                let productId = this.getAttribute('data-id');
                let element = this;

                fetch("{{ route('twill.products.changePrice') }}", {
                    "credentials": "include",
                    "body": JSON.stringify({
                        "id": productId,
                        'price': price,
                    }),
                    "headers": {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        "Accept": "application/json, text/plain, */*",
                        "Accept-Language": "ru,en-US;q=0.7,en;q=0.3",
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json",
                    },
                    "method": "PUT",
                    "mode": "cors"
                }).then(e => {
                    if (e.ok) {
                        element.classList.toggle('price-changed-sucessful');
                        window.TWILL.vm.$store.commit('setNotification', {
                            message: 'Стоимость изменена на ₽' + price,
                            variant: "success",
                        })

                        setTimeout(() => {
                            element.classList.toggle('price-changed-sucessful');
                        }, 3000);

                    } else {
                        element.classList.toggle('price-changed-fail');

                        window.TWILL.vm.$store.commit('setNotification', {
                            message: 'Попробуйте еще раз.',
                            variant: "error",
                        });
                        setTimeout(() => {
                            element.classList.toggle('price-changed-fail');
                        }, 3000);
                    }
                }).catch(e => {

                });

            }));

        });
    </script>
    <script>
        function changeStatusColor(productId, element) {


            fetch("{{ route('twill.products.publish') }}", {
                "credentials": "include",
                "body": JSON.stringify({
                    "id": productId,
                    'active': element.classList.contains('product-color_stayout') ? false : true
                }),
                "headers": {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    "Accept": "application/json, text/plain, */*",
                    "Accept-Language": "ru,en-US;q=0.7,en;q=0.3",
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json",
                },
                "method": "PUT",
                "mode": "cors"
            })
            .then(response => response.json())
            .then(e => {


                window.TWILL.vm.$store.commit('setNotification', {
                    message: e.message,
                    variant: e.variant,
                })



                element.classList.toggle('product-color_stayout');
                // ✓
                if (element.classList.contains('product-color_stayout')) {
                    element.textContent = '';
                } else {
                    element.textContent = '✓';
                }
            }).finally(() => {
                changeStatusColorWait = false;
            });

        }
    </script>
@endpush
