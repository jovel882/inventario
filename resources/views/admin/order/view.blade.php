@extends('adminlte::page')

@section('title', config('adminlte.title').' - Ver Orden')
@push('css')
@endpush

@section('content_header')
    <h1><i class="fa fa-file"></i> Ver Orden</h1>
@stop

@section('content')
    <div id="frm_raffle">
        <div class="box">
            <div class="box-body" style="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Fecha:</label>                        
                            <div class="col-sm-8">
                                <p class="col-sm-10  text-muted">{{$row->date}}</p>
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
            </div>
            <div class="box-body">
                <div class="box box-info box-solid" >
                    <div class="box-header">
                        <h3 class="box-title">Productos</h3>
                    </div>                    
                    <div class="box-body" >
                        <div class="col-sm-12" id="Capa_Tbl_Products">
                            <table id="Tbl_Products" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            </table>            
                        </div>            
                    </div>                    
                </div>                    
            </div>                    
            <div class="box-footer">
                <a type="button" class="btn btn-danger" id="btn_cancel" href="{{ route("order") }}"><i class="fa fa-fw fa-times"></i>Cancelar</a>
            </div>        
        </div>
    </div>    
@stop
@push('js')
<script type="text/javascript">
        let data_Product={!!$productsOrder??"{}"!!};
        $(document).ready(function() {
            tableProduct=$('#Tbl_Products').DataTable({
            "scrollX": true,
            "order": [ 2, "asc"],
            columns: [
                        { title: "Producto" },
                        { title: "Cantidad" },
                        { title: "En existencia" },
                        { title: "Precio" },
                        { title: "Lote" },
                        { title: "Fecha Vencimiento" },
                    ],
            });  
            data_TblProduct=new Array();
            $.each(data_Product, function( index, value ) {
                data_TblProduct.push([value.product_text,value.quantity,value.quantity_available,value.price,value.lote,value.expiry_date]); 
            });         
            tableProduct.clear();
            tableProduct.rows.add(data_TblProduct);
            tableProduct.draw();                      
        });
</script>
@endpush