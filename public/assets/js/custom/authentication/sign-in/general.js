"use strict";

// Class definition
var KTSigninGeneral = function () {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleForm = function (e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'Usernae': {
                        validators: {
                            notEmpty: {
                                message: 'The Username is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    'Passwrd': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            // Prevent button default action
            e.preventDefault();

            // Validate form
            validator.validate().then(function (status,) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;

                    let captchaResponse = grecaptcha.getResponse();
                    // ajax request
                    $.ajax({
                        url: APP_URL + '/app-login/login',
                        data: {
                            Username: $('[name="Username"]').val(),
                            Password: $('[name="Password"]').val(),
                            Captcha: captchaResponse,
                        },
                        type: "POST",
                        success: (response) => {
                            if (response.success) {
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');
                                // Enable button
                                submitButton.disabled = false;

                                $('[name="Username"]').val("");
                                $('[name="Password"]').val("");

                                // redirect to main
                                window.location.href = APP_URL + response.redirectTo;

                            } else {
                                console.log(response.message)
                                if(response.message.Captcha != '' || response.message.Username != '' || response.message.Password != ''){
                                    var text = '';
                                    if(response.message.Captcha != ''){
                                        text.push(response.message.Captcha)
                                    }else{
                                        text.push('username atau password tidak tepat')
                                    }
                                    Swal.fire({
                                        text: text,
                                        title: response.title,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function(){
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                    });
                                }else{
                                    Swal.fire({
                                        text: response.message,
                                        title: response.title,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function(){
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;
                                    });
                                }
                            }
                        }
                    });

                } else {
                    // Hide loading indication
                    submitButton.removeAttribute('data-kt-indicator');
                    // Enable button
                    submitButton.disabled = false;
                }
            });
        });
    }

    // Public functions
    return {
        // Initialization
        init: function () {
            form = document.querySelector('#kt_sign_in_form');
            submitButton = document.querySelector('#kt_sign_in_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
