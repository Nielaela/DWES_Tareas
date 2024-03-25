{{-- vista vinstalacion, modificará los valores de titulo y encabezado 
y tendrá un navegador/botón que nos llevará a la página crearDatos --}}
@extends('plantillas.plantilla1')

@section('titulo', 'Instalación')
@section('encabezado', 'Instalación')

@section('contenido')
<a href="crearDatos.php" class="btn btn-InstalarDatos" >Instalar Datos de Ejemplo</a>

@endsection