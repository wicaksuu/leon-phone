

import Alpine from 'alpinejs';
import 'preline';

window.Alpine = Alpine;
Alpine.start();

// Inisialisasi ulang komponen Preline UI ketika DOM dimuat
document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods) {
        window.HSStaticMethods.autoInit();
    }
});
