<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight  flex items-center justify-between">
            {{ __('Proyectos') }}
            <a href="{{ route('cargar_crear') }}" class="text-xs bg-gray-800 text-white rounded px-2 py-1 border">Crear</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Listado de Proyectos!") }}
                    <div class="py-12 grid grid-cols-1 place-items-center">
                        <table class="mb-4 w-full border-collapse border border-gray-400">
                                <thead>
                                    <tr class="bg-gray-500">
                                        <th>Titulo</th>
                                        <th>Descripcion</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Final</th>
                                        <th colspan="2">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proyectos as $proyecto)
                                    <tr class="border-b border-gray-200 text-sm">
                                        <td class="px-6 py-4">{{ $proyecto->titulo }}</td>
                                        <td class="px-6 py-4">{{ $proyecto->descripcion }}</td>
                                        <td class="px-6 py-4">{{ date('Y/m/d', strtotime($proyecto->fecha_inicio)) }}</td>
                                        <td class="px-6 py-4">{{ date('Y/m/d', strtotime($proyecto->fecha_final)) }}</td>
                                        <td>
                                            <span class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                <a href="{{ route('cargar_editar', $proyecto) }}">Editar</a>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if (count($proyecto->tareas) === 0)
                                            <form action="{{ route('delete', $proyecto) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <input 
                                                    type="submit" 
                                                    value="Eliminar" 
                                                    class="bg-gradient-to-r from-red-500 to-red-700 hover:bg-gradient-to-r from-red-600 to-red-800 text-white font-bold py-2 px-4 rounded shadow-lg" 
                                                    onclick="return confirm('¿Desea Eliminar el proyecto?')"
                                                >
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    {{ $proyectos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>