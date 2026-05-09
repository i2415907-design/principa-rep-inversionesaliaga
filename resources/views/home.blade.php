@extends('layouts.inicioprincipal')

@section('contentinicioprincipal')
    @include('partials.inicioprincipal.contentclienteinversiones', [
    'productos' => $productos,
    'productosPorCategoria' => $productosPorCategoria,
    'categorias' => $categorias
    ])
@endsection
