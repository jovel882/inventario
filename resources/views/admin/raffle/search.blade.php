@extends('adminlte::page')

@section('title', 'Buscar Tambolas')
@push('css')
    <link rel="stylesheet" id="style_datatable_new" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <style>
        .btn{
            margin: 0.2em 0px;
        }
    </style>
@endpush

@section('content_header')
    <h1><i class="fa fa-tags"></i> Buscar Tombolas</h1>
@stop

@section('content')
    @if(session('create'))
        <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="{{__('form-zoho.close')}}" ><i class="fa fa-fw fa-times-circle"></i></button>
            <i class="fa fa-fw fa-plus-circle"></i> La tombola se creo correctamente.
        </div>    
    @endif
    @if(session('update'))
        <div class="alert alert-info alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="{{__('form-zoho.close')}}" ><i class="fa fa-fw fa-times-circle"></i></button>
            <i class="fa fa-fw fa-refresh"></i> La tombola se actualizo correctamente.
        </div>    
    @endif
    @if(session('not_found'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="{{__('form-zoho.close')}}" ><i class="fa fa-fw fa-times-circle"></i></button>
            <i class="fa fa-fw fa-ban"></i> La tombola no existe.
        </div>    
    @endif
    <div class="box">
        <div class="box-body" style="">
            <div class="row">
                <div class="col-md-4">
                    <a name="btn_edit" id="btn_edit" href="{{url("admin/raffle/add/")}}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Agregar
                    </a>                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_view" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Fecha Sorteo</th>
                                <th>Cantidad de participantes</th>
                                <th>Estado</th>
                                <th>Creado</th>
                                <th>Actualizado</th>
                                <th>Eliminado</th>
                                <th><i class="fa fa-gears"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td>
                                        {{$row->id}}
                                    </td>
                                    <td>
                                        {{$row->name}}
                                    </td>
                                    <td>
                                        {{$row->date}}
                                    </td>
                                    <td>
                                        {{$row->participant_number}}
                                    </td>
                                    <td>
                                        {{$row->status_text}}
                                    </td>
                                    <td>
                                        {{$row->created_at}}
                                    </td>
                                    <td>
                                        {{$row->updated_at}}
                                    </td>
                                    <td>
                                        {{$row->deleted_at}}
                                    </td>
                                    <td>
                                        @if (isset($row) and $row->trashed())
                                            <a name="btn_view" id="btn_view" href="{{url("admin/raffle/view/".$row->id)}}" target="_blank" class="btn btn-warning">
                                                <i class="fa fa-eye"></i> Ver
                                            </a>                                    
                                        @else
                                            <a name="btn_edit" id="btn_edit" href="{{url("admin/raffle/edit/".$row->id)}}" class="btn btn-info" data-id="{{$row->id}}">
                                                <i class="fa fa-pencil"></i> Editar
                                            </a>

                                            <a name="btn_view" id="btn_view" href="{{url("admin/raffle/view/".$row->id)}}" target="_blank" class="btn btn-warning">
                                                <i class="fa fa-eye"></i> Ver
                                            </a>                                    

                                            <a name="btn_delete" id="btn_delete" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-id="{{$row->id}}" data-namel="{{ $row->name}}">
                                                <i class="fa fa-trash"></i> Eliminar
                                            </a>                                    
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="box box-solid box-nborder">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fw fa-times-circle"></i></button>
                        <h4 class="modal-title">Eliminar Tombola</h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <input  type="hidden" name="Ctr_IdDelete" id="Ctr_IdDelete" value="" />
                        <button type="button" class="btn btn-outline pull-left btn_Close" data-dismiss="modal"><i class="fa fw fa-ban"></i> Cancelar</button>
                        <button type="button" class="btn btn-outline btn_remove btn_DeleConf"><i class="fa fw fa-trash"></i> Eliminar</button>
                    </div>
                </div>
                <div class="overlay">
                    <i class="fa fa-circle-o-notch fa-spin"></i>
                </div>                
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>        
@stop
@push('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        let tbl_view=false;
        $(document).ready(function() {
            $('#modal-danger').find(".overlay").hide();
            $(".btn-danger").click(function(){                
                $(".modal-body").html('<p>Esta seguro de eliminar la tombola "'+$(this).data("namel")+'"?</p>');
                $("#Ctr_IdDelete").val($(this).data("id"));
            });            
            $(".btn_DeleConf").click(function(){                
                $('#modal-danger').find(".overlay").show();
                $.post('{{url("/admin/raffle/remove")}}', "id="+$("#Ctr_IdDelete").val(), function( data ) {
                    if(data=="true"){
                        window.location.href = "{{url("admin/raffle/search")}}";
                    }
                    $('#modal-danger').find(".overlay").hide();
                    $('#modal-danger').modal('hide');
                }).fail(function(){
                    $('#modal-danger').find(".overlay").hide();
                    alert("Se genero un error intenta mas tarde.");
                });                
            });            
            tbl_view=$('#tbl_view').DataTable({
                "processing": true,
                "paging":false,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    },
                    {
                        "targets": [ 8 ],
                        "orderable": false,
                    },                    
                ],
                "order": [2,"asc"],
            });
        });
</script>
@endpush