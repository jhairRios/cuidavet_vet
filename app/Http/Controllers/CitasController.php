<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Veterinario;
use App\Models\Empleado;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::with('cliente', 'veterinario')->get();
        return view('modulos.citas', compact('citas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $veterinarios = Empleado::where('id_rol', 1)->get();
        return view('modulos.citas_create', compact('clientes', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'veterinario_id' => 'required|exists:empleados,id', // Cambiado de 'veterinarios' a 'empleados'
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
        ]);

        Cita::create($request->all());
        return redirect()->route('citas')->with('success', 'Cita creada correctamente.');
    }

    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        $clientes = Cliente::all();
        $veterinarios = Veterinario::all();
        return view('modulos.citas.edit', compact('cita', 'clientes', 'veterinarios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($request->all());
        return redirect()->route('citas')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas')->with('success', 'Cita eliminada correctamente.');
    }
}