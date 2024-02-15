<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Bienvenido al gestor de proyectos y tareas") }}
                    <div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900 dark:text-gray-100">
        {{ __("Bienvenido al gestor de proyectos y tareas") }}
        <div class="py-4">
          <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex flex-row space-x-2">
              <div class="w-full">
                <label for="fecha_inicio">Fecha Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="rounded border-gray-500 bg-gray-700 text-white w-full">
              </div>
              <div class="w-full">
                <label for="fecha_final">Fecha Final:</label>
                <input type="date" name="fecha_final" id="fecha_final" class="rounded border-gray-500 bg-gray-700 text-white w-full">
              </div>
              <div class="w-full">
                <label for="buscador">buscador:</label>
                <input type="text" name="buscador" id="buscador" class="rounded border-gray-500 bg-gray-700 text-white w-full">
              </div>
              <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
              <button type="button" class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700" onclick="window.location.href='{{ route('dashboard') }}'">Limpiar</button>
            </div>
          </form>
          </div>
          <div class="py-12 grid grid-cols-1 place-items-center">
            <table class="mb-4 w-full border-collapse text-white border border-gray-400">
                <thead>
                <tr class="bg-gray-500">
                    <th>
                    <div class="cursor-pointer hover:bg-gray-400 flex items-center justify-center">
                        <span class="ml-2">
                            @if ($ordenar === 'titulo')
                                @if ($direccion === 'asc')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"></path></svg>
                                @endif
                            @endif
                        </span>
                        @if ($direccion === 'asc')
                            <a href="{{ route('dashboard', ['ordenar' => 'titulo', 'direccion' => 'asc']) }}">Titulo</a>
                        @else
                            <a href="{{ route('dashboard', ['ordenar' => 'titulo', 'direccion' => 'desc']) }}">Titulo</a>
                        @endif
                        </div>
                    </th>
                    <th>
                        <div class="cursor-pointer hover:bg-gray-400 flex items-center justify-center">
                        <span class="ml-2">
                            @if ($ordenar === 'descripcion')
                                @if ($direccion === 'asc')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"></path></svg>
                                @endif
                            @endif
                        </span>
                        @if ($direccion === 'asc')
                            <a href="{{ route('dashboard', ['ordenar' => 'descripcion', 'direccion' => 'asc']) }}">Descripcion</a>
                        @else
                            <a href="{{ route('dashboard', ['ordenar' => 'descripcion', 'direccion' => 'desc']) }}">Descripcion</a>
                        @endif
                        </div>
                    </th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proyectos as $proyecto)
                    <tr class="border-b border-gray-400 text-sm">
                    <td class="px-6 py-4">{{ $proyecto->titulo }}</td>
                    <td class="px-6 py-4">{{ $proyecto->descripcion }}</td>
                    <td class="px-6 py-4">{{ date('Y/m/d', strtotime($proyecto->fecha_inicio)) }}</td>
                    <td class="px-6 py-4">{{ date('Y/m/d', strtotime($proyecto->fecha_final)) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
      </div>
    </div>
  </div>
</div>

                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
