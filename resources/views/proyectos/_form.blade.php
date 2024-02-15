@csrf
<div class="text-white bg-gray-800 px-4 py-4">
  <div class="uppercase font-bold mb-2">
    Proyecto
  </div>
  <hr class="border-gray-500">

  <label class="text-sm">Titulo</label>
  <span class="text-red-500 text-xs">@error('titulo') {{ $message }} @enderror</span>
  <input type="text" name="titulo" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4" value="{{ old('titulo', $proyecto->titulo) }}">

  <label class="text-sm">Descripción</label>
  <span class="text-red-500 text-xs">@error('descripcion') {{ $message }} @enderror</span>
  <textarea type="text" name="descripcion" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4">{{ old('descripcion', $proyecto->descripcion) }}</textarea>

  <div class="grid grid-cols-4 gap-4 mb-4">
    <div>
      <label for="fecha_inicio" class="text-sm">Fecha Inicio:</label><br>
      <span class="text-red-500 text-xs">@error('fecha_inicio') {{ $message }} @enderror</span>
    </div>
    <input type="date" name="fecha_inicio" id="fecha_inicio" class="rounded border-gray-500 bg-gray-700 text-white w-full" value="{{ old('fecha_final', date('Y/m/d', strtotime($proyecto->fecha_inicio)) ?? today()) }}">
    <div>
      <label for="fecha_final" class="text-sm">Fecha Final:</label><br>
      <span class="text-red-500 text-xs">@error('fecha_final') {{ $message }} @enderror</span>
    </div>
    <input type="date" name="fecha_final" id="fecha_final" class="rounded border-gray-500 bg-gray-700 text-white w-full" value="{{ old('fecha_final', date('Y/m/d', strtotime($proyecto->fecha_final)) ?? today()) }}">
  </div>


  <div class="flex justify-end items-center">
    <a href="{{ route('proyectos') }}" class="btn bg-red-500 text-white px-4 py-2 me-2 rounded hover:bg-red-700">Volver</a>
    <input type="submit" value="Enviar" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
  </div>
</div>
