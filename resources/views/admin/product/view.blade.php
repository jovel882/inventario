@extends('adminlte::page')

@section('title', config('adminlte.title').' - Ver Producto')
@push('css')
<link rel="stylesheet" id="style_datatable_new" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
@endpush

@section('content_header')
    <h1><i class="fa fa-cube"></i> Ver Producto</h1>
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
                            <label class="col-sm-4 control-label">Proveedor:</label>
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->user->name}}</p>
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
                                <p class="col-sm-10  text-muted">{{$row->deleted_at??"N/A"}}</p>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="box-body">
                    <div class="box box-info box-solid" >
                        <div class="box-header">
                            <h3 class="box-title">Inventario</h3>
                        </div>                    
                        <div class="box-body" >
                            <div class="col-sm-12" id="Capa_Tbl_Products">
                                <table id="tbl_view" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Cantidad</th>
                                            <th>En existencia</th>
                                            <th>Precio</th>
                                            <th>Lote</th>
                                            <th>Fecha Vencimiento</th>
                                            <th>Creado</th>
                                            <th>Actualizado</th>
                                            <th>Eliminado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($row->order_products as $order)
                                            <tr>
                                                <td>
                                                    {{$order->id}}
                                                </td>
                                                <td>
                                                    {{$order->quantity}}
                                                </td>
                                                <td>
                                                    {{$order->quantity_available}}
                                                </td>
                                                <td>
                                                    {{$order->price}}
                                                </td>
                                                <td>
                                                    {{$order->lote}}
                                                </td>
                                                <td>
                                                    {{$order->expiry_date}}
                                                </td>
                                                <td>
                                                    {{$order->created_at}}
                                                </td>
                                                <td>
                                                    {{$order->updated_at}}
                                                </td>
                                                <td>
                                                    {{$order->deleted_at}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                            
                            </div>            
                        </div>                    
                    </div>                    
                </div>                
            </div>
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ route("product") }}"><i class="fa fa-fw fa-times"></i>Cancelar</a>
            </div>        
        </div>
    </div>    
@stop
@push('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $('#tbl_view').DataTable({
                "processing": true,
                "paging":true,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    },
                ],
                "oSearch": { "bSmart": false, "bRegex": true },
                "order": [0,"asc"],
                "scrollX": true,
            });            
        });
</script>
@endpush