import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('auth', {
    modal: null,
    open(name) { this.modal = name; },
    close() { this.modal = null; },
});

Alpine.start();
