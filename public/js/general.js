/*Funciones utiles en todo el sitio
@author John Fredy Velasco Bareño <jovel882@gmail.com>
*/
let dataDatePicket
$(document).ready(function() {
    closeFilters();
    dataDatePicket={
        "singleDatePicker": true,
        "autoApply": true,
        "ranges": {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 Días': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 Días': [moment().subtract(29, 'days'), moment()],
            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
            'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "alwaysShowCalendars": true,
        "autoUpdateInput": false,
        "showDropdowns": true,
        "showWeekNumbers": true,
        "showISOWeekNumbers": true,
        "linkedCalendars": true,
        "timePicker": false,
        "timePicker24Hour": false,
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " - ",
            "applyLabel": "Aceptar",
            "cancelLabel": "Limpiar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizado",
            "weekLabel": "S",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },
        "showCustomRangeLabel": false,
    };
});
function errorctr(status,ctr,txt=false){
    var parent=ctr.closest(".form-group");
    if(status==false){
//        parent.removeClass("has-success");
        parent.addClass("has-error");
        if(ctr.siblings(".help-block").length>0){
            ctr.siblings(".help-block").html('<i class="fa fa-times-circle-o"></i> '+txt);
        }
        else{
            parent.find(".help-block").first().html('<i class="fa fa-times-circle-o"></i> '+txt);
        }
    }
    else{
//        parent.addClass("has-success");
        parent.removeClass("has-error");
        if(ctr.siblings(".help-block").length>0){
            ctr.siblings(".help-block").html('<i class="fa fa-check text-green"></i>');
        }
        else{
            parent.find(".help-block").first().html('<i class="fa fa-check text-green"></i>');
        }
    }    
}
function errorctrSwitch(status,ctr,txt=false){
    var parent=ctr.closest(".form-group");
    if(status==false){
        parent.addClass("has-error");
        parent.find(".help-block").first().html('<i class="fa fa-times-circle-o"></i> '+txt);
    }
    else{
        parent.removeClass("has-error");
        parent.find(".help-block").first().html('<i class="fa fa-check text-green"></i>');
    }    
}
function clear_ErrorCtr(ctr){
    ctr.closest(".form-group").removeClass("has-error");
    ctr.siblings(".help-block").html('');
}
function errorgroup(status,ctr,txt=false){
    var parent=ctr.closest(".row");
    if(status==false){
//        parent.removeClass("has-success");
        parent.addClass("has-error");
        ctr.html('<i class="fa fa-times-circle-o"></i> '+txt);
//        ctr.siblings(".help-block").html('<i class="fa fa-times-circle-o"></i> '+txt);
    }
    else{
//        parent.addClass("has-success");
        parent.removeClass("has-error");
//        ctr.html('<i class="fa fa-check text-green"></i>');
        ctr.html('');
    }    
}
function moveScroolElement(element){
    if(element.length>0){
        $('html, body').animate({
            scrollTop: (element.offset().top)
        },500);    
    }
}
function validateInteger(value){
    if(value!=""){
        return /^[0-9]*$/g.test(value);
    }
    else{
        return false;
    }
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(email!=""){
        return re.test(email);
    }
    else{
        return false;
    }  
}
function validatePhone(phone){
    if(phone!=""){
        return /^[+]?[0-9 ]+$/g.test(phone);
    }
    else{
        return false;
    }            
}
function validateFloat(value,sign=false){
    if(value!=""){
        if(sign==false){
            return /^\d+(\.\d+)?$/g.test(value);
        }
        else{
            return /^-?\d+(\.\d+)?$/g.test(value);
        }
    }
    else{
        return false;
    }
}
function disableSubmit(){
    $(".disableSubmit").keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });    
}
function validateEditor(name,msg){
    var bool_cont=true;
    if(!CKEDITOR.instances[name].getData().replace(/<[^>]*>/gi, '').length){
        errorctr(false,$("#"+name),msg);
        bool_cont=false;
    }
    else{
        errorctr(true,$("#"+name));
    }
    return bool_cont;
}
function closeFilters(capa=""){
    $(capa+" .close_filters").unbind("click");
    $(capa+" .close_filters").click(function(event){
        var parent_filter=$(this).parents(".box").first();
        var boxBody=parent_filter.children(".box-body").first();
        var boxFooter=parent_filter.children(".box-footer").first();
        if(parent_filter.children("form").length!=0){
            var boxBody=parent_filter.children("form").children(".box-body").first();
            var boxFooter=parent_filter.children("form").children(".box-footer").first();
        }
        if(boxBody.hasClass('in')){
            $(this).find(".btn-box-tool").first().html('<i class="fa fa-plus"></i>');
        }
        else{
            $(this).find(".btn-box-tool").first().html('<i class="fa fa-minus"></i>');
        }
        boxBody.collapse('toggle');
        boxFooter.collapse('toggle');
        event.stopPropagation();
    });    
}
function validateSlugUrl(value){
    if(value!=""){
        return /^([0-9a-z\-_]+)([/]{1}[0-9a-z\-_]+)*$/g.test(value);
    }
    else{
        return false;
    }
}
function validateSlug(value){
    if(value!=""){
        return /^([a-z0-9\-_])+$/g.test(value);
    }
    else{
        return false;
    }
}
function string_to_slug(text, separator) {
    text = text.toString().toLowerCase().trim();

    const sets = [
        {to: 'a', from: '[ÀÁÂÃÄÅÆĀĂĄẠẢẤẦẨẪẬẮẰẲẴẶ]'},
        {to: 'c', from: '[ÇĆĈČ]'},
        {to: 'd', from: '[ÐĎĐÞ]'},
        {to: 'e', from: '[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]'},
        {to: 'g', from: '[ĜĞĢǴ]'},
        {to: 'h', from: '[ĤḦ]'},
        {to: 'i', from: '[ÌÍÎÏĨĪĮİỈỊ]'},
        {to: 'j', from: '[Ĵ]'},
        {to: 'ij', from: '[Ĳ]'},
        {to: 'k', from: '[Ķ]'},
        {to: 'l', from: '[ĹĻĽŁ]'},
        {to: 'm', from: '[Ḿ]'},
        {to: 'n', from: '[ÑŃŅŇ]'},
        {to: 'o', from: '[ÒÓÔÕÖØŌŎŐỌỎỐỒỔỖỘỚỜỞỠỢǪǬƠ]'},
        {to: 'oe', from: '[Œ]'},
        {to: 'p', from: '[ṕ]'},
        {to: 'r', from: '[ŔŖŘ]'},
        {to: 's', from: '[ßŚŜŞŠ]'},
        {to: 't', from: '[ŢŤ]'},
        {to: 'u', from: '[ÙÚÛÜŨŪŬŮŰŲỤỦỨỪỬỮỰƯ]'},
        {to: 'w', from: '[ẂŴẀẄ]'},
        {to: 'x', from: '[ẍ]'},
        {to: 'y', from: '[ÝŶŸỲỴỶỸ]'},
        {to: 'z', from: '[ŹŻŽ]'},
        {to: '-', from: '[·/_,:;\']'}
    ];

    sets.forEach(set => {
        text = text.replace(new RegExp(set.from,'gi'), set.to);
    });

    text = text.toString().toLowerCase()
        .replace(/\s+/g, '-')         // Replace spaces with -
        .replace(/&/g, '-and-')       // Replace & with 'and'
        .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
        .replace(/\--+/g, '-')        // Replace multiple - with single -
        .replace(/^-+/, '')           // Trim - from start of text
        .replace(/-+$/, '');          // Trim - from end of text

    if ((typeof separator !== 'undefined') && (separator !== '-')) {
        text = text.replace(/-/g, separator);
    }

    return text;    
}