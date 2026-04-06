'use strict';

(function () {
    // Init custom option check
    window.Helpers.initCustomOptionCheck();

    const phoneMask = document.querySelector('.contact-number-mask')

    // Phone Number Input Mask
    if (phoneMask) {
        phoneMask.addEventListener('input', event => {
            const cleanValue = event.target.value.replace(/\D/g, '');
            phoneMask.value = formatGeneral(cleanValue, {
                blocks: [3, 3, 4],
                delimiters: [' ', ' ']
            });
        });
        registerCursorTracker({
            input: phoneMask,
            delimiter: ' '
        });
    }

    // Vertical Wizard
    // --------------------------------------------------------------------

    const wizardPropertyListing = document.querySelector('#wizard-property-listing');
    if (typeof wizardPropertyListing !== undefined && wizardPropertyListing !== null) {
        // Wizard form
        const wizardPropertyListingForm = wizardPropertyListing.querySelector('#wizard-property-listing-form');
        // Wizard steps
        const wizardPropertyListingFormStep1 = wizardPropertyListingForm.querySelector('#personal-details');
        const wizardPropertyListingFormStep2 = wizardPropertyListingForm.querySelector('#company-details');
        const wizardPropertyListingFormStep3 = wizardPropertyListingForm.querySelector('#other-details');
        // Wizard next prev button
        const wizardPropertyListingNext = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-next'));
        const wizardPropertyListingPrev = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-prev'));

        const validationStepper = new Stepper(wizardPropertyListing, {
            linear: true
        });

        // Personal Details
        const FormValidation1 = FormValidation.formValidation(wizardPropertyListingFormStep1, {
            fields: {
                // * Validate the fields here based on your requirements
                fname: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter your first name'
                        }
                    }
                },
                lname: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter your last name'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: { message: 'Please enter email' },
                        emailAddress: { message: 'Please enter a valid email address' }
                    }
                },
                password: {
                    validators: {
                        callback: {
                            message: 'Password must be at least 8 characters',
                            callback: function (input) {
                                const id = (document.getElementById('company_id')?.value || '').trim();
                                const val = (input.value || '').trim();

                                // Create: password required
                                if (!id) return val.length >= 8;

                                // Edit: password optional, but if provided must be 6+
                                if (id && val.length === 0) return true;
                                return val.length >= 8;
                            }
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        callback: {
                            message: 'Passwords do not match',
                            callback: function (input) {
                                const id = (document.getElementById('company_id')?.value || '').trim();
                                const password = (document.getElementById('add-user-password')?.value || '').trim();
                                const confirm = (input.value || '').trim();

                                // Create: confirm password required & must match
                                if (!id) {
                                    return confirm.length > 0 && confirm === password;
                                }

                                // Edit: both empty → valid (keep existing password)
                                if (id && password.length === 0 && confirm.length === 0) {
                                    return true;
                                }

                                // Edit: if password is provided, confirm must match
                                if (password.length > 0) {
                                    return confirm === password;
                                }

                                return true;
                            }
                        }
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.form-control-validation'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            },
            init: instance => {
                instance.on('plugins.message.placed', function (e) {
                    //* Move the error message out of the `input-group` element
                    if (e.element.parentElement.classList.contains('input-group')) {
                        e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                    }
                });
            }
        }).on('core.form.valid', function () {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
        });

        // Company Details
        const FormValidation2 = FormValidation.formValidation(wizardPropertyListingFormStep2, {
            fields: {
                // * Validate the fields here based on your requirements

                tradingname: {
                    validators: {
                        notEmpty: { message: 'Please enter Trading name' },
                    }
                },
                companyname: {
                    validators: {
                        notEmpty: { message: 'Please enter company name' },
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter phone number'
                        },
                        regexp: {
                            regexp: /^[0-9\s()+-]+$/,
                            message: 'Please enter a valid phone number'
                        },
                        stringLength: {
                            min: 7,
                            max: 15,
                            message: 'Phone number must be between 7 and 15 digits'
                        }
                    }
                },

                billing_address: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter billing address'
                        },
                        stringLength: {
                            max: 200,
                            message: 'Billing address must be less than 200 characters'
                        }
                    }
                },
                billing_state: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter billing state'
                        },
                        stringLength: {
                            max: 100,
                            message: 'Billing state must be less than 100 characters'
                        }
                    }
                },
                billing_suburb: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter billing suburb'
                        },
                        stringLength: {
                            max: 100,
                            message: 'Billing suburb must be less than 100 characters'
                        }
                    }
                },
                billing_postcode: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter billing postcode'
                        },
                        regexp: {
                            regexp: /^[0-9]{4,6}$/,
                            message: 'Please enter a valid postcode'
                        }
                    }
                },

                delivery_address: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter delivery address'
                        },
                        stringLength: {
                            max: 200,
                            message: 'Delivery address must be less than 200 characters'
                        }
                    }
                },
                delivery_state: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter delivery state'
                        },
                        stringLength: {
                            max: 100,
                            message: 'Delivery state must be less than 100 characters'
                        }
                    }
                },
                delivery_suburb: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter delivery suburb'
                        },
                        stringLength: {
                            max: 100,
                            message: 'Delivery suburb must be less than 100 characters'
                        }
                    }
                },
                delivery_postcode: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter delivery postcode'
                        },
                        regexp: {
                            regexp: /^[0-9]{4,6}$/,
                            message: 'Please enter a valid postcode'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.form-control-validation',
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
        });

        // Other Details
        const FormValidation3 = FormValidation.formValidation(wizardPropertyListingFormStep3, {
            fields: {
                websiteurl: {
                    validators: {
                        uri: {
                            message: 'Please enter a valid website URL',
                            allowLocal: false
                        }
                    }
                },
                abnacn: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter ABN/ACN Number'
                        },
                        regexp: {
                            regexp: /^[0-9]{9,11}$/,
                            message: 'ABN must be 11 digits or ACN must be 9 digits'
                        }
                    }
                },
                platform: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a platform'
                        }
                    }
                },
                status: {
                    validators: {
                        notEmpty: { message: 'Please select status' }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    // Use this for enabling/changing valid/invalid class
                    // eleInvalidClass: '',
                    eleValidClass: '',
                    rowSelector: '.form-control-validation'
                }),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).on('core.form.valid', function () {
            wizardPropertyListingForm.submit();
        });


        wizardPropertyListingNext.forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                // When click the Next button, we will validate the current step
                switch (validationStepper._currentIndex) {
                    case 0:
                        FormValidation1.validate();
                        break;

                    case 1:
                        FormValidation2.validate();
                        break;

                    case 2:
                        FormValidation3.validate().then(function(status) {
                            if (status === 'Valid') {
                                wizardPropertyListingForm.submit();
                            }
                        });
                        break;

                    default:
                        break;
                }
            });
        });

        wizardPropertyListingPrev.forEach(item => {
            item.addEventListener('click', event => {
                switch (validationStepper._currentIndex) {
                    case 2:
                        validationStepper.previous();
                        break;

                    case 1:
                        validationStepper.previous();
                        break;

                    case 0:

                    default:
                        break;
                }
            });
        });
    }
})();
