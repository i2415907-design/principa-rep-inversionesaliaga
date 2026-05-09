@extends('layouts.productosdbly')

@section('dashhomeproductos')
    @include('layouts.content.productosdb', ['categorias' => $categorias])
@endsection
