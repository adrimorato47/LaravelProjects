<?php
/** https://www.cursosdesarrolloweb.es/blog/crud-laravel */

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $id = $consulta = DB::select("select tarea from tareas where id=:id", ['id'=>$id]);

        return view('tareas.index', compact('tareas'));
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
        return view('tareas.form', compact('tareas', 'action', 'buttonText'));
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

        return redirect()->route('tareas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        $tarea->load('user:id,tarea');
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //
    }
}
