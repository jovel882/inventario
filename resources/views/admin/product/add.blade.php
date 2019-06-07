@extends('adminlte::page')

@section('title', (config('adminlte.title')." - ".(isset($row))?'Editar':'Crear').' Producto')
@push('css')
@endpush

@section('content_header')
    <h1><i class="fa fa-cube"></i> {{((isset($row))?'Editar':'Crear')}} Producto</h1>
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
    <form name="frm_product" id ="frm_product" class="form-horizontal" action="{{route("product-add")}}" method="post">
        @if (isset($row))
            <input type="hidden" name="id" id="id" value="{{$row->id}}" />
        @endif
        {{ csrf_field() }}    
        <div class="box">
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Nombre del producto."></i>:</label>                        
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre" value="{{old('name')??$row->name??""}}" />
                                <span class="help-block"></span>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Proveedor
                                <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Proveedor del producto."></i>
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
            </div>
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ route("product") }}"><i class="fa fa-fw fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-success pull-right" id="btn_enviar"><i class="fa fa-fw fa-save"></i> {{isset($row)?"Editar":"Crear"}}</button>
            </div>        
        </div>
    </form>    
@stop
@push('js')
<script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            if( !$('#user_id').is('input') ) {
                $('#user_id').select2({
                    width: '100%',
                });            
            }
            $("#frm_product").submit(function(){
                let bool_cont=true;
                if($("#user_id").val().trim()=="none"){
                    errorctr(false,$("#user_id"),'Debes seleccionar un proveedor.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#user_id"));
                }                
                if($("#name").val().trim()==""){
                    errorctr(false,$("#name"),'Debes ingresar un nombre para el producto.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#name"));
                }
                return bool_cont;                                
            });
        });
</script>
@endpush