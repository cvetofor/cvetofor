<div class="social-floating">
    <a href="{{ $telegram }}" target="_blank" class="social-icon telegram">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram">
    </a>
    <a href="{{ $vk }}" target="_blank" class="social-icon vk">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/21/VK.com-logo.svg" alt="VK">
    </a>
    <a href="{{ $whatsapp }}" target="_blank" class="social-icon whatsapp">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const socialIcons = document.querySelectorAll('.social-icon');
        
        socialIcons.forEach((icon, index) => {
            setTimeout(() => {
                icon.style.opacity = '1';
                icon.style.transform = 'translateY(0)';
            }, index * 100);
            
            icon.style.opacity = '0';
            icon.style.transform = 'translateY(20px)';
            icon.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });
    });
</script> 