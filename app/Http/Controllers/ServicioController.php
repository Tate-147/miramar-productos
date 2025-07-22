<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ServicioController extends Controller
{
    /**
     * Muestra una lista de todos los servicios.
     * GET /servicios
     */
    public function index()
    {
        return response()->json(Servicio::all());
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     * POST /servicios
     */
    public function store(Request $request)
    {
        try {
            // Validar la petición
            $this->validate($request, [
                'codigo' => 'required|string|unique:servicios',
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'destino' => 'required|string',
                'fecha' => 'required|date',
                'costo' => 'required|numeric|min:0'
            ]);

            // Crear el servicio
            $servicio = Servicio::create($request->all());

            return response()->json($servicio, 201); // 201: Created

        } catch (ValidationException $e) {
            // Capturar errores de validación y devolver una respuesta clara
            return response()->json(['errors' => $e->errors()], 422); // 422: Unprocessable Entity
        }
    }

    /**
     * Muestra un servicio específico por su ID.
     * GET /servicios/{id}
     */
    public function show($id)
    {
        $servicio = Servicio::find($id);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404); // 404: Not Found
        }

        return response()->json($servicio);
    }

    /**
     * Actualiza un servicio existente.
     * PUT /servicios/{id}
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::find($id);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        try {
            $this->validate($request, [
                'codigo' => 'string|unique:servicios,codigo,' . $id,
                'nombre' => 'string|max:255',
                'descripcion' => 'string',
                'destino' => 'string',
                'fecha' => 'date',
                'costo' => 'numeric|min:0'
            ]);
            
            $servicio->update($request->all());

            return response()->json($servicio);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Elimina un servicio.
     * DELETE /servicios/{id}
     */
    public function destroy($id)
    {
        $servicio = Servicio::find($id);

        if (!$servicio) {
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }

        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
    }
}