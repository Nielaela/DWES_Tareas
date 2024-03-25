{{-- vista vinversiones, modificará los valores de titulo y encabezado 
En este caso los valores los recoge de inversiones.php 
tendrá el botón Nuevo Fondo que llamará a la página "fcrear" para activar el formulario
mostrará una tabla el resultado de la función "listarInversiones"
definida en la clase Inversión (es una consulta a la BD) y llamada en inversiones.php 
--}}
@extends('plantillas.plantilla1')

@section('titulo', 'Inversiones')
@section('encabezado', 'Listado de Inversiones')

@section('contenido')
<a href="fcrear.php" class="btn btn-fcrear">Nuevo Fondo</a>
@if(count($inversiones) > 0)
    <table class="table table-striped">
        <thead>
            <tr class="text-center">
                <th scope="col">Nombre del Fondo</th>
                <th scope="col">Categoría</th>
                <th scope="col">Valor de la Inversión</th>
                <th scope="col">Fecha de Inversión</th>
                <th scope="col">Rentabilidad Esperada</th>
                <th scope="col">Tasa de Retorno Anual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inversiones as $inversion)
                <tr class="text-center">
                    <td>{{ $inversion->nombre_fondo }}</td>
                    <td>{{ $inversion->categoria }}</td>
                    <td>{{ $inversion->valor_inversion }}</td>
                    <td>{{ $inversion->fecha_inversion }}</td>
                    <td>{{ $inversion->rentabilidad_esperada }}</td>
                    <td>{{ $inversion->tasa_retorno_anual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-center">No hay inversiones disponibles.</p>
@endif

@endsection