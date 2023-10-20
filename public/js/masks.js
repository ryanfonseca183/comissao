$(document).ready(function(){
    const SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    };
    $('.agency').mask('0000-0');
    $('.date').mask('00/00/0000');
    $('.expiration').mask('00/0000');
    $('.date_with_placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone_without_ddd').mask('0000-0000');
    $('.phone').mask(SPMaskBehavior, {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    });
    $('.integer').mask('0#');
    $('.thousand').mask('0000');
    $('.hundred').mask('00');
    $('.decimal').mask('#0#,00', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask("#.##0,00", {
      reverse: true, 
      onKeyPress: function(val, event, field, options){
        //Remove a máscara
        const num = Number(val.replaceAll('.', '').replace(',', '.'));
        //Verifica se o valor é maior que zero
        if(num <= 0) $(field).val('');
      }
    });
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/, optional: true
        }
      }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {reverse: true});
});