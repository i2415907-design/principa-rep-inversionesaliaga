@extends('layouts.inicioprincipal')

@section('contentinicioprincipal')
    @include('partials.inicioprincipal.contentclienteinversiones', [
    'productos' => $productos,
    'categorias' => $categorias
    ])
@endsection
