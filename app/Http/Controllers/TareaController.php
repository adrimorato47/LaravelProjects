<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

/**
 * El Controlador es el intermediario entre las rutas y la lógica de negocio.
 * Recibe las peticiones HTTP, interactúa con el Modelo y devuelve una respuesta
 * (normalmente una vista Blade o una redirección).
 *
 * Este controlador gestiona las 4 operaciones CRUD de las tareas:
 *   - index()   → Listar tareas       (GET  /tareas)
 *   - store()   → Crear tarea         (POST /tareas)
 *   - update()  → Actualizar tarea    (PUT  /tareas/{id})
 *   - destroy() → Eliminar tarea      (DELETE /tareas/{id})
 */
class TareaController extends Controller
{
    /**
     * INDEX: Muestra todas las tareas.
     *
     * Tarea::all() ejecuta: SELECT * FROM tareas
     * y devuelve una Colección (Collection) de objetos Tarea.
     *
     * Pasamos esa colección a la vista con compact('tareas'),
     * que es equivalente a ['tareas' => $tareas].
     */
    public function index()
    {
        // Obtiene todas las tareas ordenadas de más reciente a más antigua
        $tareas = Tarea::latest()->get();

        // Carga la vista "tareas.index" y le pasa la variable $tareas
        return view('tareas.index', compact('tareas'));
    }

    /**
     * STORE: Crea una nueva tarea en la base de datos.
     *
     * Recibe el objeto $request con los datos del formulario POST.
     * Antes de guardar, validamos que el campo "tarea":
     *   - 'required' → No puede estar vacío
     *   - 'string'   → Debe ser texto
     *   - 'max:255'  → No más de 255 caracteres
     *
     * Si la validación falla, Laravel redirige automáticamente
     * al formulario con los errores de validación.
     */
    public function store(Request $request)
    {
        // validate() lanza una excepción si los datos no cumplen las reglas
        $request->validate([
            'tarea' => 'required|string|max:255',
        ]);

        // create() inserta un nuevo registro en la BD:
        // INSERT INTO tareas (tarea) VALUES (?)
        // Toma los campos indicados en $fillable del modelo
        Tarea::create([
            'tarea' => $request->tarea,
        ]);

        // redirect()->back() vuelve a la página anterior (el listado)
        // with('success', '...') añade un mensaje flash a la sesión
        // Los mensajes flash solo están disponibles en la SIGUIENTE request
        return redirect()->back()->with('success', '¡Tarea creada correctamente!');
    }

    /**
     * UPDATE: Actualiza el texto de una tarea existente.
     *
     * $id es el identificador de la tarea que viene en la URL: /tareas/{id}
     * findOrFail($id) busca la tarea por su id:
     *   - Si la encuentra → devuelve el objeto Tarea
     *   - Si NO existe   → lanza un error 404 automáticamente
     */
    public function update(Request $request, $id)
    {
        // Validamos igual que en store()
        $request->validate([
            'tarea' => 'required|string|max:255',
        ]);

        // Busca la tarea o devuelve 404 si no existe
        $tarea = Tarea::findOrFail($id);

        // update() modifica el registro:
        // UPDATE tareas SET tarea = ? WHERE id = ?
        $tarea->update([
            'tarea' => $request->tarea,
        ]);

        return redirect()->back()->with('success', '¡Tarea actualizada correctamente!');
    }

    /**
     * DESTROY: Elimina una tarea de la base de datos.
     *
     * Similar al update, primero buscamos la tarea y luego la eliminamos.
     * delete() ejecuta: DELETE FROM tareas WHERE id = ?
     */
    public function destroy($id)
    {
        // Busca o lanza 404
        $tarea = Tarea::findOrFail($id);

        // Elimina el registro de la BD
        $tarea->delete();

        return redirect()->back()->with('success', '¡Tarea eliminada correctamente!');
    }
}