@extends('adminlte::page')

@section('title', 'Ver Tambola')
@push('css')
@endpush

@section('content_header')
    <h1><i class="fa fa-eye"></i> Ver Tombola</h1>
@stop

@section('content')
    <div id="frm_raffle">
        <div class="box">
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->name}}</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Fecha de sorteo:</label>
                            <div class="col-md-9 input-group">
                                <p class="col-sm-10  text-muted">{{$row->date}}</p>
                            </div>
                        </div>                                        
                    </div>                
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cantidad de participantes:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->participant_number}}</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Estado:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->status_text}}</p>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha de creacion:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->created_at}}</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha de actualizacion:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->updated_at}}</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha de eliminacion:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->deleted_at}}</p>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ url("admin/raffle/search") }}"><i class="fa fa-fw fa-times"></i>Cancelar</a>
            </div>        
        </div>
    </div>    
@stop
@push('js')
<script type="text/javascript">
        $(document).ready(function() {
        });
</script>
@endpush