<div class="p-4 bg-gray-100 min-h-screen">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center sm:text-left">Registrar Ingresos y Egresos</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <h4 class="font-bold">Error de Validación:</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col gap-8 sm:flex-row sm:gap-6 sm:justify-between mb-8">

        <div class="w-full sm:w-1/2 bg-white rounded-xl shadow-md p-5">
            <h3 class="text-xl font-semibold text-orange-600 mb-4">Registrar Ingreso</h3>

            <form action="{{ route('admin.movimientos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="ingreso">

                <div class="mb-4">
                    <label for="montoIngreso" class="block text-sm font-medium text-gray-700">Cantidad (S/)</label>
                    <input type="number" id="montoIngreso" name="monto" min="0.01" step="0.01"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-400 focus:ring-2"
                        placeholder="0.00" value="{{ old('monto') }}" required>
                </div>

                <div class="mb-4">
                    <label for="conceptoIngreso" class="block text-sm font-medium text-gray-700">Concepto</label>
                    <input type="text" id="conceptoIngreso" name="concepto"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg"
                        placeholder="Ej: Aporte de capital" value="{{ old('concepto') }}" required>
                </div>



                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 rounded-lg transition duration-200">
                    Registrar Ingreso
                </button>
            </form>
        </div>

        <div class="w-full sm:w-1/2 bg-white rounded-xl shadow-md p-5">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Registrar Egreso</h3>

            <form action="{{ route('admin.movimientos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="egreso">

                <div class="mb-4">
                    <label for="montoEgreso" class="block text-sm font-medium text-gray-700">Cantidad (S/)</label>
                    <input type="number" id="montoEgreso" name="monto" min="0.01" step="0.01"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-gray-600 focus:ring-2"
                        placeholder="0.00" value="{{ old('monto') }}" required>
                </div>

                <div class="mb-4">
                    <label for="conceptoEgreso" class="block text-sm font-medium text-gray-700">Concepto</label>
                    <input type="text" id="conceptoEgreso" name="concepto"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg"
                        placeholder="Ej: Pago de luz, Sueldos" value="{{ old('concepto') }}" required>
                </div>
                

                <button type="submit"
                    class="w-full bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 rounded-lg transition duration-200">
                    Registrar Egreso
                </button>
            </form>
        </div>
    </div>
    
    <h3 class="text-xl font-semibold text-gray-800 my-6 text-center sm:text-left">
        Balance Actual de Caja: 
        <span class="font-bold @if($balance >= 0) text-green-600 @else text-red-600 @endif">
            S/ {{ number_format($balance, 2) }}
        </span>
    </h3>

    <div class="bg-white rounded-xl shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto (S/)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrado por</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora Registro</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($movimientos as $movimiento)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movimiento->id_movimiento }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 max-w-xs">{{ $movimiento->concepto }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($movimiento->tipo === 'ingreso')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Ingreso
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Egreso
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold @if($movimiento->tipo === 'ingreso') text-green-600 @else text-red-600 @endif">
                        S/ {{ number_format($movimiento->monto, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $movimiento->usuario ? $movimiento->usuario->nombre_usuario : 'Sistema' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
    {{ \Carbon\Carbon::parse($movimiento->created_at)->format('d/m/Y H:i:s') }}
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $movimientos->links() }}
        </div>
    </div>
</div>

<script>
    function validarIngreso() {
        const monto = parseFloat(document.getElementById('montoIngreso').value);
        if (isNaN(monto) || monto <= 0) {
            alert('La cantidad de ingreso debe ser positiva.');
            return false;
        }
        return true;
    }

    function validarEgreso() {
        const monto = parseFloat(document.getElementById('montoEgreso').value);
        if (isNaN(monto) || monto <= 0) {
            alert('La cantidad de egreso debe ser positiva.');
            return false;
        }
        return true;
    }
</script>