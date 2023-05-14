
function submitForm(form, e) {
    const submitter = e.originalEvent.submitter;
    $(submitter).prop("disabled", true);
    clearFeedbackMessages(form);
    $.ajax({
        url: $(form).prop('action'),
        type: "POST",
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData:false,
        success: function(response) {
            if(response.redirect) {
                window.location.replace(response.redirect);
                return;
            }
            if(typeof handleSuccess == "function")
                handleSuccess(response);
        },
        error: function(xhr) {
            if(xhr.responseJSON.hasOwnProperty('errors')) {
                toastr.error('Alguns campos são inválidos. Por favor, confira os dados e tente novamente');
                let errors = xhr.responseJSON.errors;
                if(typeof inspectRequestErrors != 'undefined')
                    inspectRequestErrors(xhr.responseJSON.errors)
                for(let name in errors) {
                    let input = $(`[name="${name}"]`);
                    if(!input.length) input = $(`[name="${name}[]"]`).first();
                    addInvalidState(input, errors[name][0])
                }
                return
            }
            let message = xhr.responseJSON.message;
            if(! message) {
                if(xhr.status == 403) {
                    message = 'Você não possui autorização para realizar essa operação!'
                } else {
                    message = 'Não foi possível realizar a operação. Por favor, recarrege a página e tente novamente!';
                }
            }
            clearFeedbackMessages(form);
            toastr.error(message);
        },
        complete: function() {
            $(submitter).prop("disabled", false);
        }
    });
}
function clearFeedbackMessages(form) {
    $(".with-errors", $(form)).html("");
    $(".form-group", $(form)).removeClass('has-error has-danger');
}
function toggleRequired(control, bool) {
    control.prop('required', bool);
    control.closest('.form-group').find('label').toggleClass('form-label-required', bool);
}
function addInvalidState(input, message) {
    const group = input.closest('.form-group'),
       feedback = group.find('.help-block.with-errors');
   group.addClass('has-error has-danger');
   feedback.text(message);

   input.on('input.feedback', function(){
       feedback.html("");
       group.removeClass("has-error has-danger")
       $(this).off("input.feedback");
   })
}
function removeInvalidState(input, reset = true) {
    const group = input.closest('.form-group');
    group.removeClass('has-error has-danger');
    group.find('.help-block').html('');
    if(reset) input.removeClass('was-filled').val('');
}
function filePreview(input, target) {
    if(input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          target.attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
}
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
      let context = this,
             args = arguments;
      let later = function() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      let callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    }
}