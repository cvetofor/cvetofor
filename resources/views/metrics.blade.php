@if (app()->isProduction())
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(95560855, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            trackHash: true,
            ecommerce: "dataLayer"
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/95560855" style="position:absolute; left:-9999px;" alt="" />
        </div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Top.Mail.Ru counter -->
    <script type="text/javascript">
        var _tmr = window._tmr || (window._tmr = []);
        _tmr.push({
            id: "3659667",
            type: "pageView",
            start: (new Date()).getTime()
        });
        (function(d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script");
            ts.type = "text/javascript";
            ts.async = true;
            ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function() {
                var s = d.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(ts, s);
            };
            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "tmr-code");
    </script>
    <noscript>
        <div><img src="https://top-fwz1.mail.ru/counter?id=3659667;js=na" style="position:absolute;left:-9999px;"
                alt="Top.Mail.Ru" /></div>
    </noscript>
    <!-- /Top.Mail.Ru counter -->

<!-- calltouch -->
<script>
(function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)},m=typeof Array.prototype.find === 'function',n=m?"init-min.js":"init.js";s.async=true;s.src="https://mod.calltouch.ru/"+n+"?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","m80otpet");
</script>
<!-- calltouch -->
<!-- calltouch request -->
<script>
    Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector), Element.prototype.closest || (Element.prototype.closest = function (e) { for (var t = this; t;) { if (t.matches(e)) return t; t = t.parentElement } return null });
    var ct_get_val = function (form, selector) { if (!!form.querySelector(selector)) { return form.querySelector(selector).value; } else { return ''; } }
    document.addEventListener('mousedown', function (e) { CalltouchRequest(e) });
    document.addEventListener('touchend', function (e) { CalltouchRequest(e) });
    function CalltouchRequest(e) {
        var t_el = e.target;
        if (t_el.closest('form [type="submit"], form button[data-form-button]')) {
            try {
                var form = t_el.closest('form');
                var fio = ct_get_val(form, 'input[name="fio"]');
                var phoneNumber = ct_get_val(form, 'input[name="phone"]');
                var email = ct_get_val(form, 'input[name*="mail"]');
                var comment = ct_get_val(form, 'input[name="comment"]');
                var ct_site_id = window.ct('calltracking_params', 'm80otpet').siteId;
                var subject = 'Заявка с цветофор.рф';
                var ct_data = {
                    fio: fio,
                    phoneNumber: phoneNumber,
                    email: email,
                    comment: comment,
                    subject: subject,
                    requestUrl: location.href,
                    sessionId: window.ct('calltracking_params', 'm80otpet').sessionId
                };
                var post_data = Object.keys(ct_data).reduce(function (a, k) { if (!!ct_data[k]) { a.push(k + '=' + encodeURIComponent(ct_data[k])); } return a }, []).join('&');
                var CT_URL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/' + ct_site_id + '/register/';
                if ((!!phoneNumber || !!email) && !window.ct_snd_flag) {
                    window.ct_snd_flag = 1; setTimeout(function () { window.ct_snd_flag = 0; }, 30000);
                    var request = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
                    request.open("POST", CT_URL, true); request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    request.send(post_data);
                }
            } catch (e) { console.log(e); }
        }
    }
</script>
<!-- calltouch request -->
<!-- calltouch generalPixel script -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
        const targetButtons = {
            'tel:': () => generalPixel.postClick('a1'),
            'https://t.me/cvetofor_03': () => generalPixel.postClick('a2'),
            'https://t.me/Cvetofor_bot': () => generalPixel.postClick('a2'),
            'vk.com/cvetofor03': () => generalPixel.postClick('a3'),
            'https://wa.me/79676202220': () => generalPixel.postClick('a4'),
            'отправить': () => generalPixel.postClick('a5'),
            'оплатить заказ': () => generalPixel.postClick('a7')
            
        }
        document.addEventListener('click', function(e) {                                           
            const target = e.target;
                if(target.closest('button')){
                    const btn = target.closest('button')
                    try{
                        if(btn.innerText){
                            for(let key in targetButtons){
                                if(btn.innerText.toLowerCase().includes(key)) {
                                    targetButtons[key]()
                                    return
                                }
                            }
                        }
                    }catch(e){console.log(e)}
                }
                if(target.closest('a')){
                    const a = target.closest('a')
                    try{
                        if(a.href){
                            for(let key in targetButtons){
                                if(a.href.toLowerCase().includes(key)) {
                                    targetButtons[key]()
                                    return
                                }
                            }
                        }
                    }catch(e){console.log(e)}
                }
        });
});
</script>
<!-- calltouch generalPixel script -->
@endif
