@extends('adminlte::page')

@section('title', 'Rifar Tambola')
@push('css')
@endpush

@section('content_header')
    <h1><i class="fa fa-sort-numeric-asc"></i> Rifar Tombola</h1>
@stop

@section('content')
    <form name="frm_raffle" id ="frm_raffle" class="form-horizontal" action="{{url("admin/raffle/")}}" method="post">
        @csrf    
        <div class="box">
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-12">                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Tombola
                                <i class="text-light-blue fa fa-fw fa-question-circle" data-toggle="tooltip" data-placement="top" title="Tombola para el participante."></i>
                                :
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="raffle_id" id="raffle_id">
                                    <option value="none">Selecciona un tombola.</option>
                                    @php
                                        $raffles=\App\Models\Raffle::all();
                                    @endphp
                                    @foreach ($raffles as $raffle)
                                        <option value="{{$raffle->id}}">{{$raffle->name}}</option>
                                    @endforeach
                                </select>                            
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                    </div>                     
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right" id="btn_enviar"><i class="fa fa-fw fa-play-circle"></i> Obtener</button>
            </div>        
        </div>
    </form>    
@stop
@push('js')
<script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#raffle_id').select2({
                width: '100%',
            });            
            $("#frm_raffle").submit(function(){
                let bool_cont=true;
                if($("#raffle_id").val().trim()=="none"){
                    errorctr(false,$("#raffle_id"),'Debes seleccionar una tombola.');
                    bool_cont=false;
                }
                else{
                    errorctr(true,$("#raffle_id"));
                }                
                return bool_cont;                                
            });
        });
</script>
@endpush