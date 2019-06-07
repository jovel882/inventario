@extends('adminlte::page')

@section('title', config('adminlte.title').'- Buscar Productos')
@push('css')
    <link rel="stylesheet" id="style_datatable_new" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <style>
        .btn{
            margin: 0.8em 0px;
        }
    </style>
@endpush

@section('content_header')
    <h1><i class="fa fa-cubes"></i> Buscar Productos</h1>
@stop

@section('content')
    @if(session('create'))
        <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
            <i class="fa fa-fw fa-plus-circle"></i> El producto se creo correctamente.
        </div>    
    @endif
    @if(session('update'))
    <div class="alert alert-info alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
        <i class="fa fa-fw fa-refresh"></i> El producto se actualizo correctamente.
        </div>    
    @endif
    @if(session('not_found'))
    <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
        <i class="fa fa-fw fa-ban"></i> El producto no existe.
    </div>    
    @endif
    @if(session('restore'))
    <div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
        <i class="fa fa-fw fa-history"></i> El producto se restauro correctamente.
    </div>    
    @endif
    @if($delete)
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
            <i class="fa fa-fw fa-ban"></i> El producto se elimino correctamente.
        </div>    
    @endif
    @if(count( $errors ) > 0)
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="Cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
            @foreach ($errors->all() as $error)
                <div style="margin-bottom: 1em;">
                    <i class="fa fa-fw fa-warning"></i> {{ $error }}
                </div>
            @endforeach
        </div>                
    @endif    
    <div class="box">
        <div class="box-body" style="">
            <div class="row">
                <div class="col-md-4">
                    <a name="btn_edit" id="btn_edit" href="{{route('product-add')}}" class="btn btn-success">
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
                                <th>Producto</th>
                                <th>Proveedor</th>
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
                                        {{$row->user->name}}
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
                                        @if (!$row->trashed())
                                            <a name="btn_edit" id="btn_edit" href="{{route('product-edit', ['id' => $row->id])}}" class="btn btn-info">
                                                <i class="fa fa-pencil"></i> Editar
                                            </a>
                                            
                                            <a name="btn_delete" id="btn_delete" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" data-id="{{$row->id}}" data-name="{{ $row->name}}" >
                                                <i class="fa fa-trash"></i> Eliminar
                                            </a>                                    
                                        @else

                                            <a name="btn_restore" id="btn_restore" href="{{route('product-restore', ['id' => $row->id])}}" class="btn bg-olive">
                                                <i class="fa fa-history"></i> Retaurar
                                            </a>                                    
                                        @endif

                                        <a name="btn_view" id="btn_view" href="{{route('product-view',['id'=>$row->id])}}" target="_blank" class="btn btn-warning">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>                                    

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
                        <h4 class="modal-title">Eliminar Producto</h4>
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
        let interval=false;
        let time=0;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        let tbl_view=false;
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#modal-danger').find(".overlay").hide();
            $(".btn-danger").click(function(){                
                $(".modal-body").html('<p>Esta seguro de eliminar el producto "'+$(this).data("name")+'" ?</p>');
                $("#Ctr_IdDelete").val($(this).data("id"));
            });            
            $(".btn_DeleConf").click(function(){                
                $('#modal-danger').find(".overlay").show();
                $.post('{{route("product-delete")}}', "id="+$("#Ctr_IdDelete").val(), function( data ) {
                    if(data=="true"){
                        window.location.href = "{{route("product")}}?delete=true";
                    }
                    else{
                        alert("No se puede eliminar este producto.");
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
                "paging":true,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    },
                    {
                        "targets": [ 6 ],
                        "orderable": false,
                    },                    
                ],
                "oSearch": { "bSmart": false, "bRegex": true },
                "order": [0,"asc"],
                "scrollX": true,
            });
        });
        function start_interval(){
            let time_show=getTime(time);
            $('#lbl_time').html(time_show.min+":"+time_show.seg);
            time++;
            interval=setInterval(function(){
                let time_show=getTime(time);
                $('#lbl_time').html(time_show.min+":"+time_show.seg);
                time++;
            }, 1000);
        }
        function end_interval(){
            clearInterval(interval);
            $('#lbl_time').html("");
            time=0;
        }
        function getTime(seg){
            let min=Math.floor(seg/60);
            let seg_now=seg-(min*60);
            return {"min":(min<10?"0"+min:min),"seg":(seg_now<10?"0"+seg_now:seg_now)};
        }               
</script>
@endpush