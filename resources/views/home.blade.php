<!-- @extends('template') -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tareas') }}
    </h2>
</x-slot>
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/3.2.4/tailwind.min.css">
</head>
<body>
    <header class="bg-gray-800 text-white p-4">
        <h1>Gestor de Tareas y Proyectos</h1>
    </header>

    <main class="container mx-auto my-8">
        <section class="bg-gray text-white shadow-sm rounded p-4">
            <h2>Título de la Sección</h2>
            <br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed ultrices risus. Nunc euismod velit a purus ullamcorper, id ultrices leo tincidunt. Maecenas sit amet purus velit. Morbi euismod orci eget lacus ullamcorper, id hendrerit lectus tincidunt.
            </p>
            <br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed ultrices risus. Nunc euismod velit a purus ullamcorper, id ultrices leo tincidunt. Maecenas sit amet purus velit. Morbi euismod orci eget lacus ullamcorper, id hendrerit lectus tincidunt.
            </p>
            <br>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed ultrices risus. Nunc euismod velit a purus ullamcorper, id ultrices leo tincidunt. Maecenas sit amet purus velit. Morbi euismod orci eget lacus ullamcorper, id hendrerit lectus tincidunt.
            </p>
        </section>

        <section class="bg-white shadow-sm rounded p-4 mt-4">
            <h2>Listado de proyectos</h2>

            <ul>
                <li>Elemento de la lista 1</li>
                <li>Elemento de la lista 2</li>
                <li>Elemento de la lista 3</li>
            </ul>
        </section>
    </main>

    <footer class="bg-gray-800 text-white p-4">
        Derechos reservados &copy; 2023
    </footer>
</body>
</html>

@endsection