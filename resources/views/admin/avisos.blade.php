@extends('layouts.perfildeadm')

@section('perfilhadm')

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 border border-orange-200">
    <h1 class="text-2xl font-bold text-orange-600 mb-4">Gestión de avisos</h1>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('avisos.store') }}" class="mb-6 bg-orange-50 p-4 rounded">
        @csrf
        <div class="mb-3">
            <label class="block text-sm font-medium">Título</label>
            <input type="text" name="titulo" class="border p-2 w-full" required>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium">Mensaje</label>
            <textarea name="mensaje" class="border p-2 w-full" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium">Tipo</label>
            <select name="tipo" class="border p-2 w-full">
                <option value="general">General</option>
                <option value="oferta">Oferta</option>
                <option value="mantenimiento">Mantenimiento</option>
            </select>
        </div>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Publicar aviso</button>
    </form>

    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-orange-100">
            <tr>
                <th class="border p-2">Título</th>
                <th class="border p-2">Mensaje</th>
                <th class="border p-2">Tipo</th>
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td class="border p-2">{{ $aviso->titulo }}</td>
                    <td class="border p-2">{{ $aviso->mensaje }}</td>
                    <td class="border p-2">{{ ucfirst($aviso->tipo) }}</td>
                    <td class="border p-2">{{ $aviso->fecha_publicacion }}</td>
                    <td class="border p-2">
                        <form method="POST" action="{{ route('avisos.destroy', $aviso->id_aviso) }}">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border p-4 text-center">No hay avisos publicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
