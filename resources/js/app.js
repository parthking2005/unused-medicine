import './bootstrap';
import Alpine from 'alpinejs';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

window.Alpine = Alpine;
Alpine.start();

// Initialize date pickers
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all date pickers
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
    });

    // Initialize all time pickers
    flatpickr('.timepicker', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        time_24hr: true,
    });

    // Handle file inputs
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = input.nextElementSibling;
            if (label && fileName) {
                label.textContent = fileName;
            }
        });
    });

    // Handle mobile menu toggle
    const menuButton = document.querySelector('[data-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Handle alerts dismissal
    const alerts = document.querySelectorAll('[data-dismiss-target]');
    alerts.forEach(alert => {
        const dismissButton = alert.querySelector('[data-dismiss]');
        if (dismissButton) {
            dismissButton.addEventListener('click', () => {
                alert.remove();
            });
        }
    });

    // Handle form validation
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    // Add error message if it doesn't exist
                    let errorMessage = field.nextElementSibling;
                    if (!errorMessage || !errorMessage.classList.contains('form-error')) {
                        errorMessage = document.createElement('p');
                        errorMessage.classList.add('form-error', 'mt-1');
                        errorMessage.textContent = 'This field is required';
                        field.parentNode.insertBefore(errorMessage, field.nextSibling);
                    }
                } else {
                    field.classList.remove('border-red-500');
                    const errorMessage = field.nextElementSibling;
                    if (errorMessage && errorMessage.classList.contains('form-error')) {
                        errorMessage.remove();
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });

    // Handle dynamic form fields
    const addFieldButtons = document.querySelectorAll('[data-add-field]');
    addFieldButtons.forEach(button => {
        button.addEventListener('click', function() {
            const template = document.querySelector(button.dataset.template);
            const container = document.querySelector(button.dataset.container);
            
            if (template && container) {
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
                
                // Reinitialize date/time pickers in the new fields
                const newDatePickers = container.querySelectorAll('.datepicker');
                const newTimePickers = container.querySelectorAll('.timepicker');
                
                newDatePickers.forEach(picker => {
                    flatpickr(picker, {
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                    });
                });
                
                newTimePickers.forEach(picker => {
                    flatpickr(picker, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: 'H:i',
                        time_24hr: true,
                    });
                });
            }
        });
    });
});