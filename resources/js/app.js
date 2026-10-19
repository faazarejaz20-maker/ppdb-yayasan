import './bootstrap';
import Alpine from 'alpinejs';
import registrationWizard from './registration';

Alpine.data('registrationWizard', registrationWizard);

window.Alpine = Alpine;
Alpine.start();
