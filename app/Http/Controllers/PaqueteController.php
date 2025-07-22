<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importante para transacciones
use Illuminate\Validation\ValidationException;

class PaqueteController extends Controller
{
    /**
     * Muestra una lista de todos los paquetes.
     * GET /paquetes
     */
    public function index()
    {
        // Carga los paquetes junto con sus servicios asociados
        $paquetes = Paquete::with('servicios')->get();
        return response()->json($paquetes);
    }

    /**
     * Almacena un nuevo paquete y lo asocia con sus servicios.
     * POST /paquetes
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'servicios_ids' => 'required|array', // Se espera un array de IDs de servicios
                'servicios_ids.*' => 'exists:servicios,id' // Valida que cada ID exista en la tabla servicios
            ]);

            // Iniciar una transacción para asegurar la integridad de los datos
            DB::beginTransaction();

            // 1. Crear el paquete
            $paquete = Paquete::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            // 2. Asociar los servicios al paquete
            $paquete->servicios()->sync($request->servicios_ids);

            // Si todo salió bien, confirmar los cambios
            DB::commit();

            // Cargar la relación para la respuesta
            $paquete->load('servicios'); 

            return response()->json($paquete, 201);

        } catch (ValidationException $e) {
            DB::rollBack(); // Revertir cambios si la validación falla
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir cambios en caso de cualquier otro error
            return response()->json(['message' => 'Error al crear el paquete', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Muestra un paquete específico y calcula su costo total con descuento.
     * GET /paquetes/{id}
     */
    public function show($id)
    {
        // Cargar el paquete con sus servicios ('with') para optimizar la consulta
        $paquete = Paquete::with('servicios')->find($id);

        if (!$paquete) {
            return response()->json(['message' => 'Paquete no encontrado'], 404);
        }

        // Calcular el costo total sumando el costo de cada servicio
        $costoTotal = $paquete->servicios->sum('costo');
        $costoConDescuento = $costoTotal * 0.90; // Aplicar 10% de descuento

        // Añadir el costo calculado a la respuesta JSON
        $paquete->costo_total_paquete = number_format($costoConDescuento, 2, '.', '');

        return response()->json($paquete);
    }

    /**
     * Actualiza un paquete existente y/o sus servicios asociados.
     * PUT /paquetes/{id}
     */
    public function update(Request $request, $id)
    {
        $paquete = Paquete::find($id);

        if (!$paquete) {
            return response()->json(['message' => 'Paquete no encontrado'], 404);
        }

        try {
            $this->validate($request, [
                'nombre' => 'string|max:255',
                'descripcion' => 'string',
                'servicios_ids' => 'sometimes|array', // 'sometimes' = si existe, debe ser array
                'servicios_ids.*' => 'exists:servicios,id'
            ]);

            DB::beginTransaction();

            // Actualizar los datos principales del paquete
            $paquete->update($request->only(['nombre', 'descripcion']));

            // Si se envían servicios_ids, sincronizarlos
            if ($request->has('servicios_ids')) {
                $paquete->servicios()->sync($request->servicios_ids);
            }
            
            DB::commit();
            
            // Recargar las relaciones para devolver el objeto actualizado
            $paquete->load('servicios');

            return response()->json($paquete);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el paquete', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Elimina un paquete. La tabla pivote se limpia automáticamente por la configuración
     * de la clave foránea ('onDelete_cascade').
     * DELETE /paquetes/{id}
     */
    public function destroy($id)
    {
        $paquete = Paquete::find($id);

        if (!$paquete) {
            return response()->json(['message' => 'Paquete no encontrado'], 404);
        }

        $paquete->delete();

        return response()->json(['message' => 'Paquete eliminado correctamente'], 200);
    }
}