$(document).ready(function(){
    $('#divStep2').css('display','inline-block');
    $('#divStep3').css('display','none');
    $('#previous_btn').css('display','none');
    $('#next_btn').css('display','inline-block');

    $(document).on('click','#address-link',function(){
        $.ajax({
            url: shipmentDetailsUrl,
            type: 'POST',
            success: function(response){
                if(response.result != ""){
                    $('#addressForm #address').val(response.result.address);
                    $('#addressForm #city').val(response.result.city);
                    $('#addressForm #state').val(response.result.state);
                    $('#addressForm #postal_code').val(response.result.pincode);
                    $('#addressForm #country [value='+response.result.shipping_country+']').attr('selected', 'true');
                }
            }
        });

        $.magnificPopup.open({
            items: {src: '#addressForm'},
            type: 'inline',
            closeOnBgClick: false,
            enableEscapeKey: false,
            midClick: true,
            callbacks: {
                open: function(){
                    $('#addressForm #address-error').remove();
                    $('#addressForm #city-error').remove();
                    $('#addressForm #state-error').remove();
                    $('#addressForm #postal_code-error').remove();
                    $('#addressForm #country-error').remove();
                    $('#addressForm .error-div').html('');
                },
                close:function(){ 
                }
            }
        });
    });

    $(document).on('click','#payment-link',function(){
        $.magnificPopup.open({
            items: {src: '#paymentForm'},
            type: 'inline',
            closeOnBgClick: false,
            enableEscapeKey: false,
            midClick: true,
            callbacks: {
                open: function(){
                    $('#PaymentDetailsForm input').val('');
                    $('#PaymentDetailsForm select').val('')
                    $('#paymentForm .error').html('');
                },
                close:function(){ 
                }
            }
        });
    });

    $(document).on('click','#primary-contact-link',function(){
        $.ajax({
            url: primaryDetailsUrl,
            type: 'POST',
            success: function(response){
                if(response.result != "error"){
                    $('#primaryContactForm #firstname').val(response.result.firstname);
                    $('#primaryContactForm #lastname').val(response.result.lastname);
                    $('#primaryContactForm #email').val(response.result.email);
                    $('#primaryContactForm #phone').val(response.result.phone);
                    $('#primaryContactForm #country_phonecode [value='+response.result.phonecode_country+']').attr('selected', 'true');
                }
            }
        });

        $.magnificPopup.open({
            items: {src: '#primaryContactForm'},
            type: 'inline',
            closeOnBgClick: false,
            enableEscapeKey: false,
            midClick: true,
            callbacks: {
                open: function(){
                    $('#primaryContactForm input').val('');
                    $('#primaryContactForm #firstname-error').remove();
                    $('#primaryContactForm #lastname-error').remove();
                    $('#primaryContactForm #email-error').remove();
                    $('#primaryContactForm #phone-error').remove();
                    $('#primaryContactForm #country_phonecode-error').remove();
                    $('#primaryContactForm .error-div').html('');
                },
                close:function(){ 
                }
            }
        });
    });
    
    $('#service-desc-link').magnificPopup({
        type:'inline',
        closeOnBgClick: false,
        enableEscapeKey: false,
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });

    $(document).on('click','#closebtn-primary,#closebtn-contact,#closebtn-payment,#closebtn-serviceDescription', function () {  
        $.magnificPopup.close();
    });
});

$("#order_frm").validate({
    highlight: function(element) {
        $(element).parents('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).parents('.form-group').removeClass('has-error');
    },
    errorElement: 'p',
    errorClass:"help-block",
});

$("#shippingForm").validate({
    // Specify validation rules
    rules: {
        address: {
            required: true,
            pattern: /^[a-zA-Z0-9\s,.'-]{2,60}[0-9]{0,10}$/
        },
        city: {
            required: true,
            pattern: /^([a-zA-Z\s]{2,20})+$/
        },
        state: {
            required: true,
            pattern: /^([a-zA-Z\s]{2,20})+$/
        },
        postal_code: {
            required: true,
            pattern: /^([a-zA-Z0-9\s-]{2,10})+$/
        },
        country: "required"
    },
    messages: shippingFormErrorMessages,
    submitHandler: function (form) { // for demo
        $.ajax({
            type: "post",
            url: updateShippingAddressUrl,
            data: $("#shippingForm").serialize(),
            success: function (response) {
                if(response.status == 'error'){
                    if(response.error_type == 'validation'){
                        $.each(response.message, function (key, val) {
                            $("#"+key+'_error').html(val);
                        });
                    }else{
                        swal('', response.message, "warning");
                    }                        
                } else{
                    swal({
                        title: "",
                        text: response.message,
                        type: "success"
                    }, function () {
                        $.magnificPopup.close();
                    });
                }                 
            }
        });
    }
});

$("#PaymentDetailsForm").validate({
    // Specify validation rules
    rules: {
        cardholder_name: {
            required: true,
            pattern: /^[a-zA-Z ]*$/,
            minlength: 6,
            maxlength: 70
        },
        card_number: {
            required: true,
            pattern: /^([0-9])+$/,
        },
        exp_month: {
            required: true,
            pattern: /^([0-9])+$/,
        },
        exp_year: {
            required: true,
            pattern: /^([0-9])+$/,
        },
        cvv: {
            required: true,
            pattern: /^([0-9])+$/
        }
    },
    messages: cardErrorMessages,
    submitHandler: function (form) {
        Stripe.setPublishableKey(stripe_pk);
        Stripe.card.createToken({
            number: $('#PaymentDetailsForm #card_number').val(),
            cvc: $('#PaymentDetailsForm #cvv').val(),
            exp_month: $('#PaymentDetailsForm #exp_month').val(),
            exp_year: $('#PaymentDetailsForm #exp_year').val(),
            name: $('#PaymentDetailsForm #cardholder_name').val(),
        }, function (status, response) {
            if (status == 200) {
                $.ajax({
                    type: "post",
                    url: updatePaymentDetailsUrl,
                    data: response,
                    success: function (response) {
                        if(response.status == 'error'){
                            swal('',response.message, "warning");                        
                        } else{
                            swal({
                                title: "",
                                text: response.message,
                                type: "success"
                            }, function () {
                                $.magnificPopup.close();
                            });
                        }                 
                    }
                });     
            } else {
                swal('',swalMsg.invalidCardErrorMsg, "warning");   
            }
        });
    }
});

$("#contactForm").validate({
    // Specify validation rules
    rules: {
        firstname: {
            required: true,
            pattern: /^[a-zA-Z]*$/,
        },
        lastname: {
            required: true,
            pattern: /^[a-zA-Z]*$/,
        },
        email: {
            required: true,
            pattern: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
            maxlength: 65
        },
        country_phonecode: {
            required: true,
            pattern: /^([A-Z]){2}$/
        },
        phone: {
            required: true,
            pattern: /^\d{9,10}$/
        }
    },
    messages: primaryContactErrorMessages,
    submitHandler: function (form) {
        $.ajax({
            type: "post",
            url: updatePrimaryDetailsUrl,
            data: $("#contactForm").serialize(),
            success: function (response) {
                if(response.status == 'error'){
                    if(response.error_type == 'validation'){
                        $.each(response.message, function (key, val) {
                            $("#"+key+'_error').html(val);
                        });
                    }else{
                        swal('', response.message, "warning");
                    }                      
                } else{
                    swal({
                        title: "",
                        text: response.message,
                        type: "success"
                    }, function () {
                        $.magnificPopup.close();
                    });
                }                 
            }
        });
    }
});

function file_click(control) {
    if (control != '') {
        var file_count = $('.order-file .UploadFile').length;
        var main_folder_text = $('.main-upload-btn ').text();
        
        if((file_count == 0) && ($('#file_upload_option_flag').val() == 0)){
            swal(error_title,error_message,"warning");
            return false;
        } else if((file_count == 0) && ($('#js-uploading_in_progress').val() == 1)){
            swal(error_title,error_message,"warning");
            return false;
        }           
    }
    if (control != '') {
        var uploaded_files_count = $('#status_'+ control).find('.UploadFile').length;
    } else{
        var uploaded_files_count = $('#status').find('.UploadFile').length;
    }
    
    if(uploaded_files_count >= 10){
        swal({
            title: swalMsg.orderPageFailedText,
            text: swalMsg.maxFileLimitMessage,
            type: "error",
            confirmButtonText: swalMsg.okBtnText
        });
        return false;
    }else{
        
        if(logged_in_user == ''){
            
            var Inputs = {};
            $("div#divStep2 :input,div#divStep2 select").each(function(){
                var element_value = $(this).val();
                var element_key = $(this).attr('id');
                Inputs[element_key] = element_value;
            });
            Inputs['category'] = category_id.trim();
            Inputs['service'] = service_id.trim();
            
            $.ajax({
                url: saveOrderFormDataUrl,
                type: 'POST',
                data: {data: JSON.stringify(Inputs)},
                success:function(result){}
            });
            $('#myModal').show();
        } else{
            if (control != '') {
                $('#'+control).click();
            }else{
                $("#js-uploading_in_progress").val(1);
                $('#files').click();
            }                    
        }
    }
}

function allow_drop(ev) {
    ev.stopPropagation();
    ev.preventDefault();
}

function drop(ev) {
    ev.stopPropagation();
    return true;
}

function check_files_and_upload(ev) {
    $('#uploadWrapper').show();
    var files = ev.target.files;
    var uploaded_files = $('#status').find('.UploadFile').length;
    if(ev.target.id != 'files'){
        uploaded_files = $('#status_'+ev.target.id).find('.UploadFile').length;
    }
    uploaded_files += files.length;
    if(uploaded_files > 10){
        swal({
            title: swalMsg.orderPageFailedText,
            text: swalMsg.maxFileLimitMessage,
            type: "error",
            confirmButtonText: swalMsg.okBtnText
        });
        return false;
    }else{
        handleFileSelect(ev, files);
    }
}

function ChangeStep(flag){
    var errorFlag = 0;
    var isTrueSet = (flag == 'True');
    if(isTrueSet == true) {
        $('.apply_coupon_for,.submit_order_info').addClass('btn_invisible');
        $('.apply_coupon_for,.submit_order_info').removeClass('btn_visible');
        $("#step3Wizard").removeClass('active');
        $("#step2Wizard").addClass('active');
        $('#divStep2').css('display','inline-block');
        $('#divStep3').css('display','none');
        $('#previous_btn').css('display','none');
        $('#next_btn').css('display','inline-block');
    }  else{
        var errorFlag = order_form_validation();
        if (!errorFlag) {
            $("#inner_spinner").hide();
            swal({
                title: swalMsg.detailMissingWarningMessage,
                text: swalMsg.mendatoryFieldErrorMessage,
                customClass: 'custom_sweetalert_bottom'
            });
            return false;
        }
        $('.apply_coupon_for,.submit_order_info').removeClass('btn_invisible');
        $('.apply_coupon_for,.submit_order_info').addClass('btn_visible');
        $("#step2Wizard").removeClass('active');
        $("#step3Wizard").addClass('active');
        $('#divStep2').css('display','none');
        $('#divStep3').css('display','inline-block');
        $('#previous_btn').css('display','inline-block');
        $('#next_btn').css('display','none');
    }
}

function order_form_validation() {
    return $("#order_frm").valid();
}

function AlignerChange() {
    cancel_coupon();
    var aligner_id = $('#aligner_option_id').val();
    var aligner_options = JSON.parse(aligner_plans);
    var result = aligner_options.filter(function (aligner_options) {return aligner_options.id == aligner_id});
    var aligner_note = result[0].aligner_note;
    $('#aligner_msg').html(aligner_note);

    calculate_amount();
}

function showArrow(){
    if(userShipAddress == ''){
        $("#js-user_ship_address").parent().find(".js-show_arrow").addClass("show_arrow");
    }
    
    if(userCardNumber == ''){
        $("#js-user_card_number").parent().find(".js-show_arrow").addClass("show_arrow");
    }

    if(userShipAddress != '' && userCardNumber != ''){
        $(".submit_order_info.js-show_arrow #js-order_now_btn").val(1);
    }
}

function calculate_amount(){
    var aligner = $('#aligner_option_id').val();
    var service_id = $('#service_id').val();
    var implants = $('#implants').val();
    var shipping_id = $('#shipping_option_dropdown').val();

    var digital_denture_flag = 0;
    if($('#digital_denture_checkbox').prop("checked") == true){
        digital_denture_flag = 1;
    }

    var checkboxArr = [];
    $(".dynamic-checkbox").each(function () {
        if($(this).prop('checked') == true){
            checkboxArr.push($(this).attr('id'));
        }
    });

    var RadioArr = [];
    $(".dynamic-radio").each(function () {
        var targetElement = $(this).attr('id');
        var targetEleValue = targetElement.split("_");
        if($(this).prop('checked') == true){
            RadioArr[ targetEleValue[0] ] = targetEleValue[1];
        }
    });

    var DropdownArr = [];
    $(".dynamic-dropdown").each(function () {
        var targetElement = $(this).attr('id');
        var targetEleValue = $(this).val();
        DropdownArr[ targetElement ] = targetEleValue;
    });

    var PreferredLab = $('select#DynamicLabOption').val();
    var preferredLabField = get_lab_option(PreferredLab);
    
    var data = {
                'service_id' : encodeURIComponent(service_id),
                'implants' : encodeURIComponent((typeof implants != 'undefined') ? implants : ''),
                'shipping_id' : encodeURIComponent((typeof shipping_id != 'undefined') ? shipping_id : ''),
                'aligner' : encodeURIComponent((typeof aligner != 'undefined') ? aligner : ''),
                'digital_denture_flag' : encodeURIComponent((typeof digital_denture_flag != 'undefined') ? digital_denture_flag : ''),
                'checkboxArr' : encodeURIComponent(JSON.stringify(checkboxArr)),
                'RadioArr' : encodeURIComponent(JSON.stringify(Object.assign({},RadioArr))),
                'DropdownArr' : encodeURIComponent(JSON.stringify(Object.assign({},DropdownArr))),
                'LabField' : encodeURIComponent(preferredLabField)
            };
    $.ajax({
        type: "post",
        url: calculateOrderAmountUrl,
        data: {data},
        success: function (response) {
            $('#paid_amount').val(response.price);
        }
    });
}

function get_lab_option(selectedPreferredLab){
    var preferredLabField = '';
    $('#LabOptions').css('display','none');
    if(typeof selectedPreferredLab != 'undefined' && selectedPreferredLab != ''){
        $('#LabOptions').css('display','block');
        var preferredLabField = $('select#DynamicLabOption').attr('name');
        if(typeof preferredLabField == 'undefined'){
            preferredLabField = '';
        }else{
            preferredLabField = preferredLabField.split('_');
            preferredLabField = preferredLabField[1];
        }
    }
    return preferredLabField;
}

function child_dropdown_option(Company,flag= ''){
    params = $('select[name="'+Company+'"]').val();
    if(params == 'None of These' || params == ''){
        if(flag == ''){
            $('#subFormControl_'+Company).html('');
        }else{
            $('select option').parents('#subFormControl_'+Company).find('option').remove();
        }        
    }else{
        $.ajax({
            url: childCompanyUrl, //the page containing php script
            type: 'post', //request type,
            data: {params:params,Input:Company},
            success:function(result){
                if($('#subFormControl_'+Company).hasClass('dependent_label_div') == true){
                    $('#subFormControl_'+Company).css('display','block');
                }else{
                    $('#subFormControl_'+Company).css('display','inline-block');
                }
            
                $('#subFormControl_'+Company).html('');
                $('#subFormControl_'+Company).append(result);
            }
        });
    }
}

function apply_coupon(){
    var coupon_code = $('#coupon_code').val();
    var shipping_option_id = $('#shipping_option_id').val();
    var amount = $('#paid_amount').val();
    $('.coupon_error').remove();
    $.ajax({
        url: applyCouponUrl,
        type: 'post',
        data: {coupon_code:coupon_code,service_id:service_id,amount:amount,shipping_option_id:shipping_option_id},
        success:function(response){
            if(response.status == 'error'){
                $('.hidecoupon br').remove();
                $('.coupon_error').remove();
                $('.hidecoupon').append('<br><span class="coupon_error">'+response.message+'</span>');
                $('#paid_amount').val(response.amount);
                return false;
            }else{
                $('#coupon_id').val(response.coupon_details.id);                        
                $('#paid_amount').val(response.amount);
                $('#applied').val(coupon_code);
                $('.hidecoupon').hide();
                $('.showcoupon').show();
                return true;
            }       
        }
    });  
}

function cancel_coupon(){
    $('.hidecoupon').show();
    $('.showcoupon').hide();
    $('#coupon_id').val('');
    calculate_amount();
}

function change_service(){
    var service_id = $('#service_id').val();

    window.location.replace(orderpageUrl+'/'+service_id);
}