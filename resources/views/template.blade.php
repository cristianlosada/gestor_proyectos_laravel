<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
    <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                @auth
                  <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                  </x-nav-link>
                  <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('tareas.index')" :active="request()->routeIs('tareas')">
                        {{ __('Tareas') }}
                    </x-nav-link>
                  </div>
                  <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                      <x-nav-link :href="route('proyectos')" :active="request()->routeIs('proyectos')">
                          {{ __('Proyectos') }}
                      </x-nav-link>
                  </div>
                @else
                  <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                  </x-nav-link>
                @endauth
                    
                </div>
            </div>
</div>
        @yield('content')
    </body>
</html>
