@csrf
<div class="text-white bg-gray-800 px-4 py-4">
  <div class="uppercase font-bold mb-2">
    Proyecto
  </div>
  <label class="text-sm">Proyecto Asignado</label>
  <span class="text-red-500 text-xs">@error('proyecto') {{ $message }} @enderror</span>
  <select name="proyecto" id="proyecto" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4">
    @foreach ($proyectos as $proyecto)
      <option value="{{ $proyecto['id'] }}" @selected(old('proyecto', !isset($tarea) ? $tarea->proyecto->id : '') === $proyecto['id'])>{{$tarea->proyecto->titulo}}</option>
    @endforeach
  </select>

  <div class="uppercase font-bold mb-2">
    Tarea relacionada
  </div>
  <hr class="border-gray-500">

  <label class="text-sm">Nombre</label>
  <span class="text-red-500 text-xs">@error('titulo') {{ $message }} @enderror</span>
  <input type="text" name="titulo" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4" value="{{ old('titulo', $tarea->titulo) }}">

  <label class="text-sm">Descripción</label>
  <span class="text-red-500 text-xs">@error('descripcion') {{ $message }} @enderror</span>
  <textarea type="text" name="descripcion" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4">{{ old('descripcion', $tarea->descripcion) }}</textarea>

  <label for="estado_tarea" class="text-sm">Estado Tarea</label>
  <span class="text-red-500 text-xs">@error('estado_tarea') {{ $message }} @enderror</span>
  <select name="estado_tarea" id="estado_tarea" class="rounded border-gray-500 bg-gray-700 text-white w-full mb-4">
    <option value="1" @selected(old("estado_tarea", $tarea->estado_tarea) === "pendiente")>Pendiente</option>
    <option value="2" @selected(old("estado_tarea", $tarea->estado_tarea) === "en progreso")>En Progreso</option>
    <option value="3" @selected(old("estado_tarea", $tarea->estado_tarea) === "completada")>Completada</option>
  </select>

  <div class="flex justify-end items-center">
    <a href="{{ route('tareas.index') }}" class="btn bg-red-500 text-white px-4 py-2 me-2 rounded hover:bg-red-700">Volver</a>
    <input type="submit" value="Enviar" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
  </div>
</div>
