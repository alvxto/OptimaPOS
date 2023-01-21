"use strict";

// Class Definition
var KTPasswordResetNewPassword = function () {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            },
                            callback: {
                                message: 'Please enter valid password',
                                callback: function (input) {
                                    if (input.value.length > 0) {
                                        return validatePassword();
                                    }
                                }
                            }
                        }
                    },
                    'confirm-password': {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger({
                        event: {
                            password: false
                        }
                    }),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        submitButton.addEventListener('click', async function (e) {
            e.preventDefault();

            validator.revalidateField('password');

            validator.validate().then(async function (status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    // ajax request
                    $.ajax({
                        url: APP_URL + '/app-login/changePassword',
                        data: {
                            password: $('[name="password"]').val(),
                            id: $('[name="id"]').val(),
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

        form.querySelector('input[name="password"]').addEventListener('input', function () {
            if (this.value.length > 0) {
                validator.updateFieldStatus('password', 'NotValidated');
            }
        });
    }

    var validatePassword = function () {
        return (passwordMeter.getScore() === 100);
    }

    // Public Functions
    return {
        // public functions
        init: function () {
            form = document.querySelector('#kt_new_password_form');
            submitButton = document.querySelector('#kt_new_password_submit');
            passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTPasswordResetNewPassword.init();
});
