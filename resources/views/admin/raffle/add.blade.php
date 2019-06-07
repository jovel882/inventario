@extends('adminlte::page')

@section('title', ((isset($row))?'Editar':'Crear').' Tambola')
@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endpush

@section('content_header')
    <h1><i class="fa fa-tag"></i> {{((isset($row))?'Editar':'Crear')}} Tombola</h1>
@stop

@section('content')
    @if(count( $errors ) > 0)
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="{{__('form-zoho.close')}}" ><i class="fa fa-fw fa-times-circle"></i></button>
            @foreach ($errors->all() as $error)
                <div style="margin-bottom: 1em;">
                    <i class="fa fa-fw fa-warning"></i> {{ $error }}
                </div>
            @endforeach
        </div>                
    @endif  
    <form name="frm_raffle" id ="frm_raffle" class="form-horizontal" action="{{url("admin/raffle/add")}}" method="post">
        @if (isset($row))
            <input type="hidden" name="id" id="id" value="{{$row->id}}" />
        @endif
        @csrf    
        <div class="box">
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Nombre para la tombola."></i>:</label>                        
                            <div class="col-sm-8">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" value="{{old('name')??$row->name??""}}" />
                                <span class="help-block"></span>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha de sorteo <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Fechas de sorteo para la tombola."></i>:</label>
                            <div class="col-md-9 input-group">
                                <input type="text" name="date" id="date" readonly="true" value="{{old('date')??$row->date??""}}" class="form-control" value="" placeholder="Fecha de sorteo"/>
                                <label class="input-group-addon btn open-datetimepicker" for="testdate">
                                    <span class="fa fa-calendar"></span>
                                </label>                                                                 
                                <span class="help-block" style="display: table-row;"></span>
                            </div>
                        </div>                                        
                    </div>                
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cantidad de participantes <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Es la cantidad de participantes para la tombola."></i>:</label>                        
                            <div class="col-sm-8">
                                <input type="number" min="1" step="1" name="participant_number" id="participant_number" class="form-control" placeholder="Cantidad de participantes" value="{{old('participant_number')??$row->participant_number??""}}" />
                                <span class="help-block"></span>
                            </div>
                        </div>                    
                    </div>
                    @if (isset($row))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Estado <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Estado para la tombola."></i>:</label>                        
                                <div class="col-sm-8">
                                    <select class="form-control" name="status" id="status">
                                            <option value="none">Selecciona un estado.</option>
                                            <option value="0" {{((null!==old('status') and old('status')==0) or (old('status')===null and $row->status==0))?'selected="selected"':''}}>Creado</option>
                                            <option value="1" {{((null!==old('status') and old('status')==1) or (old('status')===null and $row->status==1))?'selected="selected"':''}}>Inicio</option>
                                            <option value="2" {{((null!==old('status') and old('status')==2) or (old('status')===null and $row->status==2))?'selected="selected"':''}}>Finalizo</option>
                                    </select>                                         
                                    <span class="help-block"></span>
                                </div>
                            </div>                    
                        </div>
                    @endif                    
                </div>
            </div>
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ url("admin/raffle/search") }}"><i class="fa fa-fw fa-times"></i> Cancelar</a>
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
                        <h4 class="modal-title">Editar Tombola</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <input  type="hidden" name="Ctr_IdDelete" id="Ctr_IdDelete" value="false" />
                        <button type="button" class="btn btn-outline pull-left btn_Close" data-dismiss="modal"><i class="fa fw fa-ban"></i> Cancelar</button>
                        <button type="button" class="btn btn-outline btn_remove btn_DeleConf"><i class="fa fw fa-save"></i> Editar</button>
                    </div>
                </div>
            </div>
            <div class="overlay">
                <i class="fa fa-circle-o-notch fa-spin"></i>
            </div>                            
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>        
@stop
@push('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript">
        let status={{isset($row)?$row->status:"false"}};
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#modal-danger').find(".overlay").hide();
            $('#status').select2({
                width: '100%',
            });            
            $('#date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "minDate": new Date(),
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
            });
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
            $(".btn_DeleConf").click(function(){
                $('#modal-danger').find(".overlay").show();                
                $("#Ctr_IdDelete").val("true");
                $("#frm_raffle").submit();
            });                        
            $("#frm_raffle").submit(function(){
                let bool_cont=true;
                if($("#name").val().trim()==""){
                    errorctr(false,$("#name"),'Debes ingresar un nombre para la tombola.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#name"));
                }
                if($("#date").val().trim()==""){
                    errorctr(false,$("#date"),'Debes ingresar una fecha para la tombola.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#date"));
                }
                if($("#participant_number").val().trim()=="" || validateInteger($("#participant_number").val())==false || $("#participant_number").val().trim()<=0){
                    errorctr(false,$("#participant_number"),'Debes ingresar una cantidad de participante entero valido para la tombola.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#participant_number"));
                }
                if($("#status").val().trim()=="none"){
                    errorctr(false,$("#status"),'Debes seleccionar un estado para la tombola.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#status"));
                }
                if(bool_cont==true){
                    if((status==2 || status==1) && $("#status").val()==0 && $("#Ctr_IdDelete").val()!="true"){
                        $('#modal-danger').modal('show');
                        $(".modal-body").html('<p>Si cambia el estado a creado, el soteo se eliminara y todas las posiciones seran reiniciadas, esta seguro de hacer este cambio?</p>');
                        return false;                                
                    }
                    else{
                        return true;                                
                    }
                }
                else{
                    return false;                                
                }
            });
        });
</script>
@endpush