{{-- vista vcrear, modificará los valores de titulo y encabezado 
y tendrá un formulario de recogida de datos, que a través de POST enviará estos valores al servidor
y llamará a la página "crearInversión.php" que será la encargada de validar esos datos y generar al nueva instancia.
También tiene un botón limpiar para refrescar el formulario, y un botón/navegador que enviará a la pagina principal "index.php" --}}
@extends('plantillas.plantilla1')

@section('titulo', 'Crear Fondo')
@section('encabezado', 'Crear Fondo')

@section('contenido')
    <form action="crearInversion.php" method="post">
      <div class="formulario">

        <label for="nombreFondo">Nombre del Fondo:</label>
        <input type="text" name="nombre_fondo" required placeholder="Nombre del Fondo">
        
        <label for="categoria">Categoría:</label>
        <select name="categoria" required>
            <option value="Renta Fija">Renta Fija</option>
            <option value="Renta Variable">Renta Variable</option>
            <option value="Renta Global">Renta Global</option>
            <option value="Otro">Otro</option>
        </select>
        
        <label for="valor">Valor de la Inversión:</label>
        <input type="text" name="valor_inversion" required placeholder="Valor de la Inversión">
        
        <label for="fecha">Fecha de la Inversión:</label>
        <input type="date" name="fecha_inversion" required>
        
        <label for="rentabilidad">Rentabilidad Esperada:</label>
        <input type="text" name="rentabilidad_esperada" required placeholder="Rentabilidad Esperada">
        
        <label for="tasaRetornoAnual">Tasa de Retorno Anual (opcional):</label>
        <input type="text" name="tasa_retorno_anual"  placeholder="Tasa de Retorno Anual">
    </div>
    <div class="botones">
        <br> <br>
        <input type="submit" value="Crear" name="crearFondo" class="btn btn-formCrear"/>
        {{-- <a href="crearInversion.php" class="btn btn-formCrear">Crear</a> --}}
        <button type="reset" class="btn btn-formLimpiar">Limpiar </button>
        <a href="index.php" class="btn btn-formVolver">Volver</a>
    </div>
    </form>
@endsection