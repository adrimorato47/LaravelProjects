@extends('layouts.app')

@section('title', 'Mis Tareas')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">📝 Mi Lista de Tareas</h1>

    {{-- ==========================================
         MENSAJES FLASH
         session('success') comprueba si existe un mensaje
         flash en la sesión con la clave 'success'.
         Los mensajes flash se borran tras mostrarse.
    =========================================== --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ==========================================
         FORMULARIO CREAR TAREA
         action="{{ route('tareas.store') }}" apunta al método store()
         @csrf genera un token de seguridad oculto que Laravel
         verifica en cada POST para prevenir ataques CSRF.
    =========================================== --}}
    <form action="{{ route('tareas.store') }}" method="POST" class="flex gap-2 mb-8">
        @csrf
        <input
            type="text"
            name="tarea"
            placeholder="Escribe una nueva tarea..."
            value="{{ old('tarea') }}"
            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        {{-- old('tarea') recupera el valor anterior si la validación falló --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold transition">
            Añadir
        </button>
    </form>

    {{-- Errores de validación del formulario de creación --}}
    @error('tarea')
        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
    @enderror

    {{-- ==========================================
         LISTA DE TAREAS
         $tareas es la Collection que viene del controlador.
         @forelse es como @foreach pero con un @empty para
         cuando la colección está vacía.
    =========================================== --}}
    @forelse($tareas as $tarea)
        <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center justify-between gap-3">

            {{-- FORMULARIO EDITAR (inline) --}}
            {{-- @method('PUT') genera un campo oculto _method=PUT
                 porque los navegadores solo soportan GET y POST.
                 Laravel detecta este campo y enruta al método update(). --}}
            <form
                action="{{ route('tareas.update', $tarea->id) }}"
                method="POST"
                class="flex-1 flex gap-2"
            >
                @csrf
                @method('PUT')
                <input
                    type="text"
                    name="tarea"
                    value="{{ $tarea->tarea }}"
                    class="flex-1 border border-gray-200 rounded px-3 py-1 text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                >
                <button type="submit" class="text-yellow-500 hover:text-yellow-600 font-medium text-sm">
                    Guardar
                </button>
            </form>

            {{-- FORMULARIO ELIMINAR --}}
            {{-- @method('DELETE') hace lo mismo que PUT pero para DELETE --}}
            <form
                action="{{ route('tareas.destroy', $tarea->id) }}"
                method="POST"
                onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?')"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 font-medium text-sm">
                    Eliminar
                </button>
            </form>

        </div>
    @empty
        {{-- Se muestra cuando $tareas está vacía --}}
        <p class="text-center text-gray-400 py-10">No tienes tareas todavía. ¡Añade la primera!</p>
    @endforelse

</div>
@endsection