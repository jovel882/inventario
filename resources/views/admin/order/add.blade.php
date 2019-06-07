@extends('adminlte::page')

@section('title', (config('adminlte.title')." - ".(isset($row))?'Editar':'Crear').' Orden')
@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <style>
        .btn{
            margin: 0.2em 0px;
        }
    </style>    
@endpush

@section('content_header')
    <h1><i class="fa fa-file"></i> {{((isset($row))?'Editar':'Crear')}} Orden</h1>
@stop

@section('content')
    @if(count( $errors ) > 0)
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="Cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
            @foreach ($errors->all() as $error)
                <div style="margin-bottom: 1em;">
                    <i class="fa fa-fw fa-warning"></i> {{ $error }}
                </div>
            @endforeach
        </div>                
    @endif  
    <form name="frm_order" id ="frm_order" class="form-horizontal" action="{{route("order-add")}}" method="post">
        <input type="hidden" name="data_Product" id="data_Product" value="" />
        @if (isset($row))
            <input type="hidden" name="id" id="id" value="{{$row->id}}" />
        @endif
        {{ csrf_field() }}    
        <div class="box">
            <div class="box-body" style="">
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Fechas de la orden."></i>:</label>
                            <div class="col-md-9 input-group">
                                <input type="text" name="date" id="date" readonly="true" value="{{old('date')??$row->date??""}}" class="form-control" value="" placeholder="Fechas de la orden"/>
                                <label class="input-group-addon btn open-datetimepicker" for="testdate">
                                    <span class="fa fa-calendar"></span>
                                </label>                                                                 
                                <span class="help-block" style="display: table-row;"></span>
                            </div>
                        </div>                                        
                    </div>
                <div class="row">
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Proveedor
                                <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Proveedor de la orden."></i>
                                :
                            </label>
                            <div class="col-sm-8">
                                @if (auth()->user()->hasRole('Super Administrator'))
                                    <select class="form-control" name="user_id" id="user_id">
                                        <option value="none">Selecciona un proveedor.</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{$provider->id}}" {{((null!==old('user_id') and old('user_id')==$provider->id) or (isset($row) and old('user_id')===null and $row->user_id==$provider->id))?'selected="selected"':''}}>{{$provider->name}}</option>
                                        @endforeach
                                    </select>                            
                                @else
                                    <label class="text-muted">{{auth()->user()->name}}</label>
                                    <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}" />
                                @endif
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>                    
                </div>
                <div class="box box-default box-solid" id="box-productAdd" >
                    <div class="box-header">
                            <h3 class="box-title">Productos</h3>
                    </div>                    
                    <div class="box-body">
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <a data-toggle="collapse" href="#div_FrmAddProduct" role="button" class="btn btn-success ">
                                <i class="fa fa-fw fa-plus"></i> <span>Agregar</span>
                            </a>
                        </div>
                        <div class="col-sm-12" >
                            <div class="box box-primary box-solid collapse" id="div_FrmAddProduct" >
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>    
                                <div class="box-body">
                                    <div class="box box-info box-solid" >
                                        <div class="box-header">
                                            <h3 class="box-title">Producto</h3>
                                        </div>                    
                                        <div class="box-body" >
                                            <div class="row">
                                                <div class="col-md-12">                        
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Producto
                                                            <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Producto."></i>
                                                            :
                                                        </label>
                                                        <div class="col-sm-8" id="div_product">
                                                            <div id="div_selectProduct">
                                                                <select class="form-control disableSubmit" name="product_id" id="product_id">
                                                                </select>                            
                                                                <span class="help-block"></span>
                                                            </div>
                                                        </div>
                                                    </div>                        
                                                </div>
                                            </div>
                                        </div>                    
                                    </div>                                                
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Cantidad <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Es la cantidad del produto en la orden."></i>:</label>                        
                                            <div class="col-sm-8">
                                                <input type="number" min="1" step="1" name="quantity" id="quantity" class="form-control disableSubmit" placeholder="Cantidad" value="" />
                                                <span class="help-block"></span>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Precio <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Es el precio del produto en la orden."></i>:</label>                        
                                            <div class="col-sm-8">
                                                <input type="number" name="price" id="price" class="form-control disableSubmit" placeholder="Precio" value="" min="1" step="0.01"/>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Lote <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Lote del producto en la orden."></i>:</label>                        
                                            <div class="col-sm-8">
                                                <input type="text" name="lote" id="lote" class="form-control disableSubmit" placeholder="Lote" value="" />
                                                <span class="help-block"></span>
                                            </div>
                                        </div>                    
                                    </div>                                    
                                    <div class="col-md-3">                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Fecha de vencimiento<i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Fechas de vencimiento del producto en la orden."></i>:</label>
                                            <div class="col-md-9 input-group">
                                                <input type="text" name="expiry_date" id="expiry_date" readonly="true" value="" class="form-control disableSubmit" value="" placeholder="Fechas de la orden"/>
                                                <label class="input-group-addon btn open-datetimepicker" for="testdate">
                                                    <span class="fa fa-calendar"></span>
                                                </label>                                                                 
                                                <span class="help-block" style="display: table-row;"></span>
                                            </div>
                                        </div>                                        
                                    </div>                                                                                
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-6 ">
                                            <input type="hidden" name="id_product" id="id_product" value="" />
                                            <button type="button" class="btn btn-primary" id="btn_AddProduct"></button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a data-toggle="collapse" href="#div_FrmAddProduct" role="button" href="#" class="btn btn-danger">
                                                <i class="fa fa-fw fa-remove"></i> <span>Cancelar</span>
                                            </a>                
                                        </div>
                                    </div>            
                                </div>    
                            </div>
                        </div>
                        <div class="col-sm-12" id="Capa_Tbl_Products">
                            <table id="Tbl_Products" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            </table>            
                        </div>
                        <div class="col-md-12 text-center row">
                            <span class="help-block" id="msg_ErrorProduct"></span>
                        </div>                        
                    </div>
                </div>                
            </div>
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ route("order") }}"><i class="fa fa-fw fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-success pull-right" id="btn_enviar"><i class="fa fa-fw fa-save"></i> {{isset($row)?"Editar":"Crear"}}</button>
            </div>        
        </div>
    </form>
    <div class="modal modal-warning fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="box box-solid box-nborder">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fw fa-times-circle"></i></button>
                        <h4 class="modal-title">Cambiar Proveedor</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <input  type="hidden" name="Ctr_IdDelete" id="Ctr_IdDelete" value="false" />
                        <button type="button" class="btn btn-outline pull-left btn_Close" data-dismiss="modal"><i class="fa fw fa-ban"></i> Cancelar</button>
                        <button type="button" class="btn btn-outline btn_remove btn_DeleConf"><i class="fa fw fa-save"></i> Cambiar</button>
                    </div>
                </div>
            </div>
            <div class="overlay">
                <i class="fa fa-circle-o-notch fa-spin"></i>
            </div>                            
        </div>
    </div>        
@stop
@push('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript">
    let products={!!$products??"[]"!!};
    let products_select=[];
    let data_Product={!!$productsOrder??"{}"!!};
    let data_TblProduct=new Array();
    let tableProduct=false;
    let lastSel = false;
    $(document).ready(function() {
        $('#modal-danger').find(".overlay").hide();
        $('[data-toggle="tooltip"]').tooltip();
        disableSubmit();
        if( !$('#user_id').is('input') ) {
            $('#user_id').select2({
                width: '100%',
            });                        
            $('#user_id').change(function (){
                if($("#Ctr_IdDelete").val()!="true" && lastSel!=$(this).val() && lastSel!="none"){
                    $('#modal-danger').modal('show');
                    $(".modal-body").html('<p>Si cambia el proveedor, se eliminaran lo productos de la orden, esta seguro de hacer este cambio?</p>');
                }
                else{
                    if(lastSel!=$(this).val()){
                        $("#div_product").append('<span class="help-block" id="product_load"><i class="fa fa-circle-o-notch fa-spin"></i> Filtando</span>');
                        $('#div_selectProduct').hide(1,function(){
                            formatDataProducts($('#user_id').val());
                            $(this).slideDown(1,function(){
                                $("#product_load").remove();
                            });
                        });
                        data_Product={};
                        loadTableProduct();
                        $("#Ctr_IdDelete").val("false");
                        lastSel=$('#user_id').val();
                    }
                }
            });
        }
        $(".btn_DeleConf").click(function(){
            $('#modal-danger').find(".overlay").show();                
            $("#Ctr_IdDelete").val("true");
            $('#user_id').trigger('change');
            $('#modal-danger').modal('hide');
        });
        $('#modal-danger').on('hidden.bs.modal', function () {
            if($("#Ctr_IdDelete").val()!="true"){
                $('#user_id').val(lastSel).trigger('change');
            }
        })                
        formatDataProducts($('#user_id').val());
        lastSel = $('#user_id').val();            
        $('#date').daterangepicker(dataDatePicket);
        $('#date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });            
        $('#date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.endDate.format(picker.locale.format));
        });
        $('.open-datetimepicker').click(function(event){
            event.preventDefault();
            $(this).siblings("#date").click();
        });                        
        $('#expiry_date').daterangepicker(dataDatePicket);
        $('#expiry_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });            
        $('#expiry_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.endDate.format(picker.locale.format));
        });
        $('.open-datetimepicker').click(function(event){
            event.preventDefault();
            $(this).siblings("#expiry_date").click();
        });                        
        $("#frm_order").submit(function(){
            let bool_cont=true;
            if($("#date").val().trim()=="" || isNaN(new Date($("#date").val()))){
                errorctr(false,$("#date"),'Debes seleccionar una fecha valida para la orden.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#date"));
            }            
            if($("#user_id").val().trim()=="none"){
                errorctr(false,$("#user_id"),'Debes seleccionar un proveedor.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#user_id"));
            }
            if(bool_cont==true){
                if(Object.keys(data_Product).length<=0){
                    errorgroup(false,$("#msg_ErrorProduct"),"Debes incluir al menos un produto en la orden.");
                    bool_cont=false;                    
                }
                else{
                    errorgroup(true,$("#msg_ErrorProduct"));
                    $("#data_Product").val(JSON.stringify(data_Product));
                }                
            }                
            return bool_cont;                                
        });


        $('#div_FrmAddProduct').on('hidden.bs.collapse', function (e) {
            $('#id_product').val('');
            $('#product_id').val('none').trigger('change');
            $('#quantity').val('');
            $('#price').val('');
            $('#lote').val('');
            $('#expiry_date').val('');
            clear_ErrorCtr($('#product_id'));
            clear_ErrorCtr($('#quantity'));
            clear_ErrorCtr($('#price'));
            clear_ErrorCtr($('#lote'));
            clear_ErrorCtr($('#expiry_date'));
            e.stopPropagation();                
        });
        $('#div_FrmAddProduct').on('show.bs.collapse', function () {
            $(this).find(".box-title").first().html('<i class="fa fa-file"></i> '+(($('#id_product').val().trim()!="")?'Editar Producto':'Crear Producto'));
            $(this).find("#btn_AddProduct").html('<i class="fa fa-fw fa-save"></i> '+(($('#id_product').val().trim()!="")?'Guardar':'Crear'));
        });
        $('#div_FrmAddProduct').on('shown.bs.collapse', function () {
            $("#div_FrmAddProduct input:text, #div_FrmAddProduct textarea ,#div_FrmAddProduct select").first().focus();
        });
        tableProduct=$('#Tbl_Products').DataTable({
            "scrollX": true,
            "columnDefs": [ {
                "targets": [6],
                "orderable": false
            } ],
            "order": [ 2, "asc"],
            columns: [
                        { title: "ID" },
                        { title: "Producto" },
                        { title: "Cantidad" },
                        { title: "Precio" },
                        { title: "Lote" },
                        { title: "Fecha Vencimiento" },
                        { title: '<i class="fa fa-gears"></i>' },
                    ],
        });
        tableProduct.on( 'draw', function () { 
            bindEventProduct();
        });                        
        loadTableProduct();
        $("#btn_AddProduct").click(function(){
            var bool_cont=true;
            if($("#product_id").val().trim()=="none"){
                errorctr(false,$("#product_id"),'Debes seleccionar un producto.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#product_id"));
                if(validateProductInOrder($("#product_id").val())==false){
                    errorctr(false,$("#product_id"),'El producto ya se encuentra agregado en la orden.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#product_id"));
                }
            }
            if($("#quantity").val().trim()=="" || validateInteger($("#quantity").val())==false || $("#quantity").val().trim()<=0){
                errorctr(false,$("#quantity"),'Debes ingresar una cantidad de producto entero valido para la orden.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#quantity"));
            }            
            if($("#price").val().trim()=="" || validateFloat($("#price").val())==false || $("#price").val().trim()<=0){
                errorctr(false,$("#price"),'Debes ingresar un precio de producto valido para la orden.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#price"));
            }
            if($("#lote").val().trim()==""){
                errorctr(false,$("#lote"),'Debes ingresar un lote para el producto.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#lote"));
            }
            if($("#expiry_date").val().trim()=="" || isNaN(new Date($("#expiry_date").val()))){
                errorctr(false,$("#expiry_date"),'Debes seleccionar una fecha valida de vencimiento del producto.');
                bool_cont=false;
            }
            else{
                errorctr(true,$("#expiry_date"));
            }                        
            if(bool_cont==true){
                $('#div_FrmAddProduct').collapse('hide');
                var id_product=$('#id_product').val().trim();
                if(id_product!=""){
                    data_Product[id_product].product_id=$("#product_id").val().trim();
                    let data = $('#product_id').select2('data');
                    data_Product[id_product].product_text=data[0].text;
                    data_Product[id_product].quantity=$("#quantity").val().trim();
                    data_Product[id_product].price=$("#price").val().trim();
                    data_Product[id_product].lote=$("#lote").val().trim();
                    data_Product[id_product].expiry_date=$("#expiry_date").val().trim();
                }
                else{
                    let data = $('#product_id').select2('data');
                    data_Product["new_"+(Object.keys(data_Product).length+1)]={"product_id":$("#product_id").val().trim(),"product_text":data[0].text,"quantity":$("#quantity").val().trim(),"price":$("#price").val().trim(),"lote":$("#lote").val().trim(),"expiry_date":$("#expiry_date").val().trim()};
                }    
                loadTableProduct();
            }
            else{
                moveScroolElement($(".has-error"));
            }
            return false;
        });        


    });
    function formatDataProducts(data){
        products_select=[];
        products_select.push({"id":"none","text":"Selecciona un producto.","selected": true});    
        $.each(products, function (key,obj) {
            if(data==obj.user_id){
                products_select.push({"id":obj.id,"text":obj.name});    
            }
        });
        $('#product_id').empty();
        $('#product_id').select2({
            width: '100%',
            data: products_select,
        });            
    }
    function loadTableProduct(){
        data_TblProduct=new Array();
        $.each(data_Product, function( index, value ) {
            data_TblProduct.push([index,value.product_text,value.quantity,value.price,value.lote,value.expiry_date,'<button type="button" class="btn btn-info btn_EditProduct" data-id="'+index+'"><i class="fa fa-fw fa-edit"></i> Editar</button> <button type="button" class="btn btn-danger btn_DeleteProduct" data-id="'+index+'"><i class="fa fa-fw fa-remove"></i> Eliminar</button>']); 
        });         
        tableProduct.clear();
        tableProduct.rows.add(data_TblProduct);
        tableProduct.draw();
    }
    function validateProductInOrder(product_id){
        let bool=true;
        $.each(data_Product, function( index, value ) {
            if(value.product_id==product_id && ($("#id_product").val().trim()=="" || ($("#id_product").val().trim()!="" && data_Product[$("#id_product").val()].product_id!=value.product_id))){
                bool=false;
                return false;
            } 
        });
        return bool;         
    }    
    function bindEventProduct(){
        $(".btn_DeleteProduct").unbind("click");
        $(".btn_DeleteProduct").click(function(){
            delete data_Product[$(this).data("id")];
            var keys = Object.keys(data_Product);
            var tmp={};
            var parts = String($(this).data("id")).split('_');
            var id_delete=(parts.length>1)?parts[1]:false;
            for (var j=0; j < keys.length; j++) {
                var parts = keys[j].split("_");
                var key =(parts.length>1)?("new_"+(parts[1]-(parts[1]>id_delete?1:0))):keys[j];
                tmp[key] = data_Product[keys[j]];
            }
            data_Product=tmp;
            loadTableProduct();
            if($("#div_FrmAddProduct").is(':visible') && $('#id_product').val()==$(this).data("id")){
                $('#div_FrmAddProduct').collapse('hide');
            }
        });            
        $(".btn_EditProduct").unbind("click");
        $(".btn_EditProduct").click(function(){
            $('#product_id').val(data_Product[$(this).data("id")].product_id).trigger('change');
            $('#quantity').val(data_Product[$(this).data("id")].quantity);
            $('#price').val(data_Product[$(this).data("id")].price);
            $('#lote').val(data_Product[$(this).data("id")].lote);
            $('#expiry_date').val(data_Product[$(this).data("id")].expiry_date);
            $('#id_product').val($(this).data("id"));
            $('#div_FrmAddProduct').collapse('show');
            moveScroolElement($('#div_FrmAddProduct'));
        });            
    }            
</script>
@endpush