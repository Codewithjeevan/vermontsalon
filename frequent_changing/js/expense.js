$(function () {
    "use strict";

    $(document).on('keydown', '.integerchk1', function(e){ 
        let keys = e.which || e.keyCode;
        return (
        keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });

    $(document).on('keyup', '.integerchk1', function(e){
        
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });
    
    
    $(document).on('keyup input', '#amount', function(e){ 
        let amount=$('#amount').val();
        if(Number(amount)==0){              
            $("#payment_method_id").prop("disabled", true);          
        }else{            
            $("#payment_method_id").prop("disabled", false);
        }
        updateVatBreakdown();
    });

    // Allow only numbers and a single decimal point in the VAT % field
    $(document).on('input', '#vat_percentage', function(){
        let v = $(this).val();
        // strip anything that is not digit or dot
        v = v.replace(/[^0-9.]/g, '');
        // keep only the first dot
        let firstDot = v.indexOf('.');
        if (firstDot !== -1) {
            v = v.substring(0, firstDot + 1) + v.substring(firstDot + 1).replace(/\./g, '');
        }
        // clamp 0..100
        if (v !== '' && v !== '.' && Number(v) > 100) {
            v = '100';
        }
        $(this).val(v);
        updateVatBreakdown();
    });

    function updateVatBreakdown(){
        let $bd = $('#vat_breakdown');
        if ($bd.length === 0) return;

        let amount = parseFloat($('#amount').val());
        let vat    = parseFloat($('#vat_percentage').val());

        if (isNaN(amount)) amount = 0;
        if (isNaN(vat))    vat    = 0;

        // Hide if no amount entered
        if (amount <= 0) {
            $bd.hide();
            return;
        }

        // Inclusive calculation: amount already contains VAT
        let net    = vat > 0 ? amount / (1 + (vat / 100)) : amount;
        let vatAmt = amount - net;

        $('#vat_rate_label').text(vat);
        $('#vat_net_amount').text(net.toFixed(2));
        $('#vat_amount_value').text(vatAmt.toFixed(2));
        $('#vat_total_value').text(amount.toFixed(2));
        $bd.show();
    }

    // Run once on load to show breakdown when editing
    updateVatBreakdown();

});