document.addEventListener('DOMContentLoaded', function(e) {
    var thisWebDomain = 'https://'+window.location.hostname+'/';

    const formSignInUser = document.getElementById('formSignInUser');
    const buttonSignInUser = document.getElementById('buttonSignInUser');

    const formAddVoteCenter = document.getElementById('formAddVoteCenter');
    const buttonAddVoteCenter = document.getElementById('buttonAddVoteCenter');

    const formAddMERMember = document.getElementById('formAddMERMember');
    const buttonAddMERMember = document.getElementById('buttonAddMERMember');

    const formSignInMember = document.getElementById('formSignInMember');
    const buttonSignInMember = document.getElementById('buttonSignInMember');

    const formGetVotante = document.getElementById('formGetVotante');
    const btnGetVotante = document.getElementById('btnGetVotante');

    // =========== LOGIN FORM ===========
    try {
        const fv = FormValidation.formValidation(formSignInUser, {

            fields: {
                login_email: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta la dirección de correo.'
                        },
                        emailAddress: {
                            message: 'La dirección de correo no es válida.'
                        }
                    }
                },
                login_password: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta la contraseña.'
                        },
                        stringLength: {
                            min: 8,
                            message: 'La contraseña debe tener un mínimo de 8 caracteres.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap3: new FormValidation.plugins.Bootstrap3(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                /*recaptcha3: new FormValidation.plugins.Recaptcha3({
                    action: 'signup',
                    // Replace with your verification back-end URL
                    backendVerificationUrl: thisWebDomain+'_recaptcha-check.php',
                    element: 'captchaContainer',
                    message: 'The captcha is not valid or expired',
                    // Replace with the site key provided by Google
                    siteKey: '6LfWWdUUAAAAAEuGLPvtSX0glZVjNc_3H9w7cQCG',
                    // A minimum score, between 0 and 1. By default, it's set as 0.
                    // The backend verification will be treated as invalid if the returned score doesn't exceed this option.
                    // 1.0 is very likely a good interaction, 0.0 is very likely a bot
                    minimumScore: 0.8
                })*/
            }
        }).on('core.form.valid', function() {
            checkLoginUser();
        });

        buttonSignInUser.addEventListener('click', function() {
            fv.validate().then(function(status) {

            });
        });
    }
    catch(err) {
        //console.log(err.message);
    }

    // =========== ADD VOTE CENTER FORM ===========
    try {
        const fv = FormValidation.formValidation(formAddVoteCenter, {

            fields: {
                center_name: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta el nombre del centro.'
                        },
                        stringLength: {
                            min: 10,
                            max: 100,
                            message: 'El nombre debe tener entre 10 y 100 caracteres.'
                        },
                        regexp: {
                            regexp: /^[0-1a-zA-ZñÑáÁéÉíÍóÓúÚÄËÏÖÜäëïöü.\- ]+$/,
                            message: 'Solo se admiten caracteres alfanuméricos.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap3: new FormValidation.plugins.Bootstrap3(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                })
            }
        }).on('core.form.valid', function() {
            sendCenterInfo();
        });

        buttonAddVoteCenter.addEventListener('click', function() {
            fv.validate().then(function(status) {

            });
        });
    }
    catch(err) {
        //console.log(err.message);
    }

    // =========== ADD MEMBER FORM ===========
    try {
        const fv = FormValidation.formValidation(formAddMERMember, {

            fields: {
                member_dni: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta el número de indentidad.'
                        },
                        stringLength: {
                            min: 15,
                            max: 15,
                            message: 'El número de identidad debe tener 13 digitos.'
                        },
                        regexp: {
                            regexp: /^[0-9\-]+$/,
                            message: 'Formato incorrecto.'
                        }
                    }
                },
                member_role: {
                    validators: {
                        notEmpty: {
                            message: 'Seleccione el cargo desempeñado.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap3: new FormValidation.plugins.Bootstrap3(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                })
            }
        }).on('core.form.valid', function() {
            addMERMember();
        });

        buttonAddMERMember.addEventListener('click', function() {
            fv.validate().then(function(status) {

            });
        });
    }
    catch(err) {
        //console.log(err.message);
    }


    // =========== LOGIN FORM MER MEMBER ===========
    try {
        const fv = FormValidation.formValidation(formSignInMember, {

            fields: {
                member_dni: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta el número de indentidad.'
                        },
                        stringLength: {
                            min: 15,
                            max: 15,
                            message: 'El número de identidad debe tener 13 digitos.'
                        },
                        regexp: {
                            regexp: /^[0-9\-]+$/,
                            message: 'Formato incorrecto.'
                        }
                    }
                },
                login_password: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta la contraseña.'
                        },
                        stringLength: {
                            min: 8,
                            message: 'La contraseña debe tener un mínimo de 8 caracteres.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap3: new FormValidation.plugins.Bootstrap3(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                /*recaptcha3: new FormValidation.plugins.Recaptcha3({
                    action: 'signup',
                    // Replace with your verification back-end URL
                    backendVerificationUrl: thisWebDomain+'_recaptcha-check.php',
                    element: 'captchaContainer',
                    message: 'The captcha is not valid or expired',
                    // Replace with the site key provided by Google
                    siteKey: '6LfWWdUUAAAAAEuGLPvtSX0glZVjNc_3H9w7cQCG',
                    // A minimum score, between 0 and 1. By default, it's set as 0.
                    // The backend verification will be treated as invalid if the returned score doesn't exceed this option.
                    // 1.0 is very likely a good interaction, 0.0 is very likely a bot
                    minimumScore: 0.8
                })*/
            }
        }).on('core.form.valid', function() {
            LoginMERMember();
        });

        buttonSignInMember.addEventListener('click', function() {
            fv.validate().then(function(status) {

            });
        });
    }
    catch(err) {
        //console.log(err.message);
    }

    // =========== FORM BUSCAR VOTANTE ===========
    try {
        const fv = FormValidation.formValidation(formGetVotante, {
            fields: {
                persona_dni: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta el número de indentidad.'
                        },
                        stringLength: {
                            min: 15,
                            max: 15,
                            message: 'El número de identidad debe tener 13 digitos.'
                        },
                        regexp: {
                            regexp: /^[0-9\-]+$/,
                            message: 'Formato incorrecto.'
                        }
                    }
                },
                persona_token: {
                    validators: {
                        notEmpty: {
                            message: 'Hace falta el token.'
                        },
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'El token debe tener 8 caracteres.'
                        },
                        regexp: {
                            regexp: /^[A-Z0-9\-]+$/,
                            message: 'Formato incorrecto.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap3: new FormValidation.plugins.Bootstrap3(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh',
                }),
                /*recaptcha3: new FormValidation.plugins.Recaptcha3({
                    action: 'signup',
                    // Replace with your verification back-end URL
                    backendVerificationUrl: thisWebDomain+'_recaptcha-check.php',
                    element: 'captchaContainer',
                    message: 'The captcha is not valid or expired',
                    // Replace with the site key provided by Google
                    siteKey: '6LfWWdUUAAAAAEuGLPvtSX0glZVjNc_3H9w7cQCG',
                    // A minimum score, between 0 and 1. By default, it's set as 0.
                    // The backend verification will be treated as invalid if the returned score doesn't exceed this option.
                    // 1.0 is very likely a good interaction, 0.0 is very likely a bot
                    minimumScore: 0.8
                })*/
            }
        }).on('core.form.valid', function() {
            getInfoVotante();
        });

        btnGetVotante.addEventListener('click', function() {
            fv.validate().then(function(status) {

            });
        });
    }
    catch(err) {
        //console.log(err.message);
    }

})
