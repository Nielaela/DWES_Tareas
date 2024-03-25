@extends('plantillas.plantilla1')
@section('titulo')
    {{$titulo}}
@endsection
@section('encabezado')
    {{$encabezado}}
@endsection
@section('contenido')
    @if (isset($mensaje))
        <div >
            <p>{{ $mensaje }}</p>
        </div>
    @endif
    <a href='fcrear.php' class='btn btn-success mt-2 mb-2'><i class='fa fa-plus'></i> Nuevo Fondo</a>
    <table class="table table-striped table-dark">
        <thead>
        <tr style="font-width: bold; font-size:1.1rem">
            <th>Nombre del Fondo</th>
            <th>Categoría</th>
            <th>Valor de la Inversión</th>
            <th>Fecha de Inversión</th>
            <th>Rentabilidad Esperada</th>
        </tr>
        </thead>
        <tbody>
        @foreach($inversiones as $inversion)
            <tr>
                <td>{{ $inversion->nombre_fondo}}</td>
                <td>{{ $inversion->categoria }}</td>
                <td>{{ $inversion->valor_inversion }}</td>
                <td>{{ $inversion->fecha_inversion }}</td>
                <td>{{ $inversion->rentabilidad_esperada }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

