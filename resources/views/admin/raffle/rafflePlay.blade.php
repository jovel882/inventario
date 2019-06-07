@extends('adminlte::page')

@section('title', 'Tombola - '.$row->name)
@push('css')
    <link rel="stylesheet" id="style_datatable_new" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" id="style_datatable_new" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/rotator/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/rotator/css/rotator.css') }}">
    <style>
        .bg { 
            /* The image used */
            /* background-image: url("{{ asset('img/Roja.png')}}"); */
        
            /* Full height */
            height: 100%; 
        
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .balota{
            width: 384px;
            height: 388px;
        }
        .center {
            height: 100%;
            padding: 117.2px 0;
            text-align: center;
            font-weight: bold;
            color: black;
        }
        #capa_balota{
            display: none;
        }
        #btn_draw{
            margin-top: 2em;
            margin-bottom: 2em;
        }
        div.dataTables_wrapper div.dataTables_filter input{
            width: 70% !important;
        }
        #number_balota,#number_balota_sec,#number_balota_pri{
            margin: 0px !important;
            font-size: 10em;
            font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
        #name_balota,#name_balota_sec,#name_balota_pri{
            margin: 0px !important;
            font-size: 5em;
            font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        }
        #name_balota{
            display: none;
        }
        #capa_balotas,#capa_balotas_pri{
            margin: 2em 0;
            display: none;
        }
        .semi{
            background-color: #D9D900 !important;
            font-size: 1.5em;
            font-weight: bold;    
        }
        .final{
            background-color: #00D900 !important;
            font-size: 1.5em;    
            font-weight: bold;    
        }
        .winner_text{
            font-weight: bold !important;    
            font-size: 10em !important;
            font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif !important;
            margin: 0px !important;
        }        
    </style>
@endpush

@section('content_header')
<h1><i class="fa fa-sort-numeric-asc"></i> Tombola - {{$row->name}} del dia {{$row->date}}.</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body" style="">
            @if($row->participant_number > $quantity_participants)
                <div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close btn_error" data-dismiss="alert" aria-label="Cerrar" ><i class="fa fa-fw fa-times-circle"></i></button>
                    <i class="fa fa-fw fa-warning"></i> Todavia no se completan todos los cupos de la tombola, hay {{$quantity_participants}} participantes de {{$row->participant_number}} definidos en la tombola.
                </div>                
            @endif   
            <div class="row">
            <div class="col-md-{{$row->participant_number > $quantity_participants?6:12}}">         
                    <div class="box box-warning box-solid box-filters" id="box-filtersFilters" style="margin: 1em 0px;">
                        <div class="box-header close_filters">
                            <h3 class="box-title"><i class="fa fa-fw fa-user"></i> Participantes</h3>
                            <div class="box-tools pull-right">              
                                <button type="button" class="btn btn-box-tool" >
                                    <i class="fa fa-plus"></i>              
                                </button>            
                            </div>                    
                        </div>        
                        <div class="box-body collapse ">
                            <table id="tbl_participant" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Numero</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>            
                </div>
                @if($row->participant_number > $quantity_participants)
                    <div class="col-md-6">         
                        <div class="box box-danger box-solid box-filters" id="box-filtersFilters" style="margin: 1em 0px;">
                            <div class="box-header close_filters">
                                <h3 class="box-title"><i class="fa fa-fw fa-user-times"></i> Faltantes</h3>
                                <div class="box-tools pull-right">              
                                    <button type="button" class="btn btn-box-tool" >
                                        <i class="fa fa-plus"></i>              
                                    </button>            
                                </div>                    
                            </div>        
                            <div class="box-body collapse ">
                                <table id="tbl_participant_empty" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>            
                    </div>            
                @endif            
            </div>            
            <div class="row" id="capa_balotas_pri">
                <div class="col-md-12" id="capa_secundaria" align="center">
                    <div class="balota bg">
                        <div class="center">
                            <h1 id="number_balota_sec"></h1>
                        </div>
                    </div>
                    <div id="winner_text" class="rotate" data-rotate-interval="2000" data-rotate-animate="zoomIn,zoomOut">
                            <h2 class="winner_text"><span class="rotate-arena"></span></h2>
                            <ul>
                                <li><i class="fa fa-star"></i> Ganador <i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i> Ganador <i class="fa fa-star"></i></li>
                            </ul>
                    </div>
                    <h3 id="name_balota_sec"></h3>
                </div>
            </div>
            <div class="row" id="capa_balotas">
                <div class="col-md-12" id="capa_primaria" align="center">
                    <div class="balota bg">
                        <div class="center">
                            <h1 id="number_balota_pri"></h1>
                        </div>
                    </div>
                    <h3 id="name_balota_pri"></h3>
                </div>
            </div>            
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-info box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-users"></i>
                            <h3 class="box-title">En Juego</h3>
                        </div>                        
                        <div class="box-body" style="">
                            <table id="tbl_tmp" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Numero</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" id="capa_pincipal" align="center">
                    @if ($paticipants!="[]")
                        <div class="balota bg" id="capa_balota">
                            <div class="center">
                                <h1 id="number_balota"></h1>
                            </div>
                        </div>
                        <h3 id="name_balota"></h3>
                        <a name="btn_draw" id="btn_draw" class="btn btn-success btn-lg">
                            <i class="fa fa-play-circle"></i> <span id="txt_btnDraw"> Sacar Balota</span>
                        </a>
                    @else
                    <div class="callout callout-danger">
                        <h4><i class="icon fa fa-ban"></i> No hay participantes para esta tombola!</h4>
                    </div>                        
                    @endif
                </div>                
                <div class="col-md-4">
                    <div class="box box-success box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-trophy"></i>
                
                            <h3 class="box-title">Resultados</h3>
                        </div>                        
                        <div class="box-body" style="">
                            <table id="tbl_select" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Nombre</th>
                                        <th>Puesto</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@stop
@push('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('vendor/rotator/js/jquery.rotator.js') }}"></script>
<script type="text/javascript">
        let data_participant={!!$paticipants??"{}"!!};
        let data_participant_temp={!!$paticipants_enable??"{}"!!};
        let data_participant_select={!!$paticipants_select??"[]"!!};
        let tbl_tmp=false;
        let tbl_select=false;
        let drawPeriods=[20,10,8,5,4];
        let totalPeriods=0;
        let totalPeriods_acum=0;
        let rnd_tmp=false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });        
        $(document).ready(function() {
            if(data_participant_temp.length<=0 && data_participant.length>0){
                finalDraw();
            }            
            tbl_tmp=$('#tbl_tmp').DataTable({
                "processing": true,
                "paging":false,
                "data": data_participant_temp,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    }
                ],
                "order": [1,"asc"],
                "columns": [
                    { "data": "name" },
                    { "data": "number" },
                ]                
            });
            $('#tbl_participant').DataTable({
                "processing": true,
                "paging":true,
                "data": data_participant,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    }
                ],
                "order": [1,"asc"],
                "columns": [
                    { "data": "name" },
                    { "data": "number" },
                ]                
            });
            let data_participant_empty=[];
            let empty;
            let quan_participant={{$row->participant_number}};
            let diff={{$row->participant_number-$quantity_participants}};
            if(data_participant.length>0){
                if(data_participant[0].number!=1){
                    empty=data_participant[0].number;
                    for(let i=1;i<empty;i++){
                        data_participant_empty.push({"number":i});
                    }                
                }
                if(data_participant[data_participant.length-1].number!=quan_participant){
                    empty=(quan_participant-data_participant[data_participant.length-1].number)+1;
                    for(let i=1;i<empty;i++){
                        data_participant_empty.push({"number":(data_participant[data_participant.length-1].number+i)});
                    }                
                }
                if(data_participant_empty.length<diff){
                    $.each( data_participant, function( key, value ) {
                        if (typeof data_participant[key+1] !== "undefined"){
                            empty=data_participant[key+1].number-value.number;
                        }
                        else{
                            empty=1;
                        }
                        if(empty>1){
                            for(let i=1;i<empty;i++){
                                data_participant_empty.push({"number":(value.number+i)});
                            }
                        }
                        if(data_participant_empty.length==diff){
                            return false;
                        }
                    });
                }
            }
            $('#tbl_participant_empty').DataTable({
                "processing": true,
                "paging":true,
                "data": data_participant_empty,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    }
                ],
                "order": [0,"asc"],
                "columns": [
                    { "data": "number" },
                ]                
            });
            tbl_select=$('#tbl_select').DataTable({
                "processing": true,
                "paging":false,
                "data": data_participant_select,
                "columnDefs": [ 
                    {
                        "className": "text-center", 
                        "targets": "_all"
                    },
                    {
                        "targets": [ 2 ],
                        // "visible": false,
                        "searchable": false,
                    },                    
                    {
                        "targets": [ 0,1 ],
                        "orderable": false,
                    },                    
                ],
                "order": [],
                "orderFixed": {
                   "pre": [ 2, 'desc' ],
                },                
                "columns": [
                    { "data": "number" },
                    { "data": "name" },
                    { "data": "order" },
                ],
                "createdRow": function (row, data, dataIndex) {
                    if(data_participant_temp.length<=0){
                        if((data_participant_select.length-2)==dataIndex){
                            $(row).addClass("semi");
                            $(row).children().eq(0).append('<br/><i class="fa fa-star-half-o"></i>');
                        }
                        else if((data_participant_select.length-1)==dataIndex){
                            $(row).addClass("final");
                            $(row).children().eq(0).append('<br/><i class="fa fa-star"></i>');
                        }
                    }
                },                                
            });
            $("#btn_draw").click(function(){
                let quantity=data_participant_temp.length;
                if(quantity>0){
                    if(!$("#capa_balota").is(':visible')){
                        $('#capa_balota').show(1,function(){
                            moveScroolElement($("#capa_balota"));
                        });
                    }
                    else{
                        moveScroolElement($("#capa_balota"));
                    }
                    if($("#name_balota").is(':visible')){
                        $('#name_balota').hide();
                    }                    
                    let time_temp=totalPeriods=totalPeriods_acum=0;
                    $("#capa_pincipal .bg").css("background-image",'url("{{ asset('img/Azul.png')}}")');
                    $(this).addClass("disabled");
                    $(this).find("i").addClass("fa-circle-o-notch fa-spin");                    
                    $(this).find("i").removeClass("fa-play-circle");
                    $("#txt_btnDraw").html("Sorteando");
                    for(let i=0;i<drawPeriods.length;i++){
                        let period=1000/drawPeriods[i];
                        totalPeriods+=drawPeriods[i];
                        for(let j=0;j<drawPeriods[i];j++){
                            time_temp+=period;
                            setTimeout(getDrawRand,time_temp);
                        }
                    }
                }
            });
        });
        function numeroAleatorio(min, max) {
            return Math.round(Math.random() * (max - min) + min);
        }
        function getDrawRand(){
            let quantity=data_participant_temp.length;
            let rand=false;
            do {
                rand=numeroAleatorio(0,(quantity-1));
            }while ( rand == rnd_tmp && quantity>1);
            rnd_tmp=rand;                        
            let data=data_participant_temp[rand];
            $("#number_balota").html(data.number);
            $("#name_balota").html(data.name);
            if(totalPeriods_acum==(totalPeriods-1)){
                $("#capa_pincipal .bg").css("background-image",'url("{{ asset('img/Roja.png')}}")');
                data.order=(data_participant_select.length+1);
                data_participant_select.push(data);
                data_participant_temp.splice(rand, 1);
                tbl_tmp.clear();
                tbl_tmp.rows.add(data_participant_temp);
                tbl_tmp.draw();                    
                tbl_select.clear();
                tbl_select.rows.add(data_participant_select);
                tbl_select.draw();
                moveScroolElement($("#capa_balota"));
                if(!$("#name_balota").is(':visible')){
                    $('#name_balota').slideDown(100);
                } 
                $("#btn_draw").removeClass("disabled");
                $("#btn_draw i").removeClass("fa-circle-o-notch fa-spin");
                $("#btn_draw i").addClass("fa-play-circle");
                $("#txt_btnDraw").html("Sacar Balota");
                $.post('{{url("/admin/participant/register/position")}}', "id="+data.id+"&position="+data.order, function( reponse ) {
                    if(reponse=="false"){
                        alert("Se genero un error y no se pudo guardar la boleta.");
                    }
                }).fail(function(){
                    alert("Se genero un error y no se pudo guardar la boleta.");
                });                                
                if(data_participant_temp.length<=1){
                    let data=data_participant_temp[0];
                    data.order=(data_participant_select.length+1);
                    data_participant_select.push(data);
                    data_participant_temp.splice(0, 1);
                    tbl_tmp.clear();
                    tbl_tmp.rows.add(data_participant_temp);
                    tbl_tmp.draw();                    
                    tbl_select.clear();
                    tbl_select.rows.add(data_participant_select);
                    tbl_select.draw();
                    finalDraw();
                    $.post('{{url("/admin/participant/register/position")}}', "id="+data.id+"&position="+data.order, function( reponse ) {
                        if(reponse=="false"){
                            alert("Se genero un error y no se pudo guardar la boleta.");
                        }
                    }).fail(function(){
                        alert("Se genero un error y no se pudo guardar la boleta.");
                    });                                        
                }
            }
            totalPeriods_acum++;
        }
        function finalDraw(){
            $("#btn_draw").slideUp(300);
            if(!$("#capa_balotas").is(':visible')){
                $("#capa_primaria .bg").css("background-image",'url("{{ asset('img/Amarilla.png')}}")');
                $("#capa_secundaria .bg").css("background-image",'url("{{ asset('img/Verde.png')}}")');
                let data=data_participant_select[(data_participant_select.length-2)];
                $("#number_balota_pri").html(data.number);
                $("#name_balota_pri").html('<i class="fa fa-star-half-o"></i><br/>'+data.name);
                data=data_participant_select[(data_participant_select.length-1)];
                $("#number_balota_sec").html(data.number);
                $("#name_balota_sec").html(data.name);                    
                $("#capa_balotas").slideDown(3000,function(){
                    moveScroolElement($("#capa_balotas"));
                    setTimeout(function(){
                        $("#capa_balotas").slideUp(5000);
                        $(".rotate").rotator();
                        $("#capa_balotas_pri").slideDown(10000,function(){
                            moveScroolElement($("#capa_balotas_pri"));
                        });                    
                    },3000)
                });
            }
            if($("#capa_balota").is(':visible')){
                $("#capa_balota").slideUp(300);
                $("#capa_balotas_pri").slideUp(300);
                if($("#name_balota").is(':visible')){
                    $('#name_balota').slideUp(300);
                }                
            }            
        }
</script>
@endpush