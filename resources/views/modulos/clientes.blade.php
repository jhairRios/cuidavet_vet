@extends('welcome')

@section('contenido')
    <section class="content-header">
        <h1>Clientes</h1>
        <div class="text-right">
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">Agregar Cliente</a>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </section>
    <section class="content table-responsive">
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="color: white; background-color: #0d98ba;">DNI</th>
                            <th style="color: white; background-color: #0d98ba;">Nombre</th>
                            <th style="color: white; background-color: #0d98ba;">Apellido</th>
                            <th style="color: white; background-color: #0d98ba;">Teléfono</th>
                            <th style="color: white; background-color: #0d98ba;">Correo</th>
                            <th style="color: white; background-color: #0d98ba;">Estado</th>
                            <th style="color: white; background-color: #0d98ba;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->dni }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->apellido }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->correo }}</td>
                                <td>{{ $cliente->estado }}</td>
                                <td>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">Editar</a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection