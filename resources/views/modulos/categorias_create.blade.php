@extends('welcome')

@section('contenido')
    <section class="content-header">
        <h1>Agregar Categoría</h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <form method="POST" action="{{ route('categorias.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('Categorias') }}" class="btn btn-default">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
