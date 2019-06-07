@extends('adminlte::page')

@section('title', config('adminlte.title').' - Error 403')

@section('content_header')
    <h1 class="headline text-red"><i class="fa fa-fw fa-times-circle"></i> Error 403. Usted no tiene acceso a este recurso.</h1>
@stop
@section('content')
<div class="error-page">
    <h2 class="headline text-red">403</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Parece que haces trampa. <i class="fa fa-thumbs-o-down text-red"></i></h3>
        <p>
            Intenta con las opciones del menu.
        </p>
        <a class="btn btn-block btn-danger" href="{{ URL::previous()}}"><i class="fa  fa-arrow-circle-left"></i> Volver</a>
    </div>
</div>
@stop
