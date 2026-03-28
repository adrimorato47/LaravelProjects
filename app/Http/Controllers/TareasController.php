<?php
/** https://www.cursosdesarrolloweb.es/blog/crud-laravel */

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;


class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::paginate(10);
        return view('tareas', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tareas = new Tarea;
        $tarea = __('Crear Tarea');
        $action = route('tareas.store');
        $buttonText = __('Crear tarea');
        return view('form', compact('tareas', 'action', 'buttonText'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareaRequest $request) :RedirectResponse
    {
        $request->validate([
            'tarea' => 'required|string|max:1000'
        ]);
        Tarea::create([
            'tarea' => $request->string('tarea')
        ]);

        return redirect()->route('tareas');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea): Renderable
    {
        $titulo = __('Editar tarea');
        $action = route('tareas.update', $tarea);
        $buttonText = __('Actualizar tarea');
        $method = 'PUT';

        return view('tareas.form', compact('tarea', 'action', 'buttonText', 'method', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $request->validate([
            'tarea' => 'required|string|max:100|unique:tareas,tarea,' . $tarea->id,
        ]);

        $tarea->update([
            'tarea' => $request->string('tarea'),
        ]);
        return redirect()->route('tareas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return redirect()->route('tareas');
    }
}
