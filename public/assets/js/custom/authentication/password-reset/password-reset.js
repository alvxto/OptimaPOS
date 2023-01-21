"use strict";

// Class Definition
var KTPasswordResetGeneral = function () {
    // Elements
    var form;
    var submitButton;
    var validator;

    var handleForm = function (e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // Validate form
            validator.validate().then(async function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    // ajax request
                    $.ajax({
                        url: APP_URL + '/app-login/sendForgot',
                        data: {
                            Email: $('[name="Email"]').val(),
                        },
                        type: "POST",
                        success: async (response) => {
                            await Swal.fire({
                                text: response.message,
                                icon: (response.success) ? "success" : 'error',
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                            if (response.success) {
                                window.location.href = APP_URL + '/app-login';
                            }
                        }
                    });
                } else {
                    await Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function () {
            form = document.querySelector('#kt_password_reset_form');
            submitButton = document.querySelector('#kt_password_reset_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTPasswordResetGeneral.init();
});
