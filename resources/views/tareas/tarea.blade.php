<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center justify-between">
            {{ __('Tareas') }}
            @if ($role->role_id === 1)
                <a href="{{ route('tareas.create') }}" class="text-xs bg-gray-800 text-white rounded px-2 py-1 border">Crear</a>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Listado de tareas!") }}
                    <div class="py-12 grid grid-cols-1 place-items-center">
                        <table class="mb-4 w-full border-collapse border border-gray-400">
                            <thead>
                                <tr class="bg-gray-500">
                                <th>Proyecto</th>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Estado Tarea</th>
                                @if ($role->role_id === 1)
                                    <th colspan="2">Opciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tareas as $tarea)
                        <tr class="border-b border-gray-200 text-sm">
                            <td class="px-6 py-4">{{ $tarea->proyecto->titulo }}</td>
                            <td class="px-6 py-4">{{ $tarea->titulo }}</td>
                            <td class="px-6 py-4">{{ $tarea->descripcion }}</td>
                            <td class="px-6 py-4
                            @switch($tarea->estado_tarea)
                                @case('pendiente')
                                    text-yellow-500
                                @break
                                @case('en progreso')
                                    text-orange-500
                                @break
                                @default
                                    text-green-500
                            @endswitch">
                            {{ $tarea->estado_tarea }}
                            </td>
                            @if ($role->role_id === 1)
                                <td>
                                    <span class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <a href="{{ route('tareas.edit', $tarea) }}">Editar</a>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('tareas.destroy', $tarea) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <input 
                                            type="submit" 
                                            value="Eliminar" 
                                            class=" bg-gradient-to-r from-red-500 to-red-700 hover:bg-gradient-to-r from-red-600 to-red-800 text-white font-bold py-2 px-4 rounded shadow-lg" 
                                            onclick="return confirm('¿Desea Eliminar la tarea?')"
                                        >
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $tareas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>