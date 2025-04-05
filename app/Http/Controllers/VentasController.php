<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth; 
use App\Models\Producto; // Importar la clase Producto
use PDF; // Importar la clase para generar PDFs

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente', 'empleado')->get();
        return view('modulos.ventas', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('cantidad', '>', 0)->get(); // Filtrar productos disponibles
        return view('modulos.ventas_create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'total' => 'required|numeric|min:0',
            'factura_rtn' => 'required|in:Sin RTN,Con RTN',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'fecha' => 'required|date', // Validar el campo fecha
        ]);

        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'rtn' => $request->factura_rtn === 'Con RTN' ? $request->rtn : null,
            'fecha' => $request->fecha, // Asignar el campo fecha
            'total' => $request->total,
            'estado' => 'Pendiente', // Cambiar según tu lógica
            'id_empleado' => Auth::id(),
        ]);

        // Guardar los productos de la venta
        foreach ($request->productos as $producto) {
            $venta->productos()->attach($producto['id'], [
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        return view('modulos.ventas_show', compact('venta'));
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $clientes = Cliente::all();
        return view('modulos.ventas_edit', compact('venta', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:Pendiente,Pagada,Cancelada',
        ]);

        $venta = Venta::findOrFail($id);

        $venta->update(array_merge($request->all(), [
            'id_empleado' => auth::id(),
        ]));

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }

    public function imprimir($id)
    {
        $venta = Venta::findOrFail($id);
        $pdf = PDF::loadView('modulos.ventas_pdf', compact('venta'));
        return $pdf->stream('venta_' . $venta->id . '.pdf');
    }
}