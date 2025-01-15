<div class="modal-dialog w-md-600px w-100 " id="editModal">
    <div class="modal-content " id="editformDiv">
        <div class="modal-header py-2">
            <h3 class="modal-title">Edit Questionnaire</h3>
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!--end::Close-->
        </div>

        <form action="{{route('quest.update',$questionnaires->id)}}" method="POST" id="editform">
            @csrf
        <div class="modal-body">
                <div class="mb-5 fv-row">
                    <label for="" class="form-label">Quesitionnaire Form Name</label>
                    <input type="text" class="form-control form-control-sm" x-model='name' value="{{$questionnaires->name}}" name="name" placeholder="Name">
                </div>

                <div class="fv-row">
                    <label for="" class="form-label">Url</label>
                    <input type="text" class="form-control form-control-sm"  x-model='url'  value="{{$questionnaires->url}}" name="url" placeholder="url">
                </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm" :disabled="button.disabled" x-text="button.text" @click="save()">Update</button>
        </div>
            </form>
    </div>
</div>
<script>
    $(document).ready(function(){
                // user update validation
        var editValidator = function () {
            // Shared variables

            const element = document.getElementById("editformDiv");
            const form = element.querySelector("#editform");
            // let value={account->current_balance}};
                    // Init add schedule modal
            var initValidator = () => {
                var validationFields = {
                            name: {
                                validators: {
                                    notEmpty: { message: "* Name is required" },
                                },
                            },
                            url: {
                                validators: {
                                    notEmpty: { message: "* Questionnaire Url is required" },
                                },
                            },
                        };
                var validator = FormValidation.formValidation(
                    form,
                    {
                        fields:validationFields,

                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',
                                eleValidClass: ''
                            })
                        },

                    }
                );
                // Submit button handler
                const submitButton = element.querySelector('[data-kt-action="submit"]');
                submitButton.addEventListener('click', function (e) {
                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                e.currentTarget=true;
                                return true;
                            } else {
                                e.preventDefault();
                                // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });


            }
            // Select all handler

            return {
                // Public functions
                init: function () {
                    initValidator();
                }
            };
        }();
        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            editValidator.init();
        });

        function validationField(form) {
            $('.fv-plugins-message-container').remove();
            let accountId=$('#payment_account').val();
            let paidAmountValidator;

            var validationFields = {
                    name:{
                        validators: {
                            notEmpty: { message: "* Payment Account Name is required" }
                        },
                    },
                    currency_id:{
                        validators: {
                            notEmpty: { message: "* Currency is required" }
                        },
                    },
            };
            return  FormValidation.formValidation(
                form,
                {
                    fields:validationFields,
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    },

                }
            );
        }
    })
</script>
