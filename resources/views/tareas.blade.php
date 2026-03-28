<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        @section("content")
            <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>
            <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
                <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                    <h1>Aqui va ista de la compra</h1>
                    <table>
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <th class="px-4 py-2">{{ __('Tarea') }}</th>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($tareas as $tarea)

                                <tr>
                                    <td class="border px-4 py-2">{{$tareas->tarea}}

                                    </td>
                                        <td class="border px-4 py-2" style="width: 260px">
                                            <a href="{{ route('tareas.show', $tarea) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Ver') }}</a>
                                            <a href="{{ route('tareas.edit', $tarea) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Editar') }}</a>
                                            <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{ __('Eliminar') }}</button>
                                            </form>
                                        </td>
                                </tr>
                                @empty
                                    <tr class="bg-red-400 text-white text-center">
                                        <td colspan="3" class="border px-4 py-2">{{ __('No hay tareas para mostrar') }}</td>
                                    </tr>
                            @endforelse
                        </tbody>
                        @if ($tareas->hasPages())
                                <tfoot class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="border px-4 py-2">
                                            {{ $tareas->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                    </table>
                </main>
            </div>

            @if (Route::has('login'))
                <div class="h-14.5 hidden lg:block"></div>
            @endif
        @endsection
    </body>
</html>
