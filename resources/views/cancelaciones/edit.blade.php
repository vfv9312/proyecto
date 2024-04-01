@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar motivo de cancelación</h1>
@stop

@section('content')
    <form action="{{ route('cancelar.update', $cancelar->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del motivo:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $cancelar->nombre }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
