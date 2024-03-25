<?php $__env->startSection('titulo'); ?>
    <?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('encabezado'); ?>
    <?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contenido'); ?>
    <form name="crear" method="POST" action="crearInversion.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nombreFondo">Nombre del Fondo</label>
                <input type="text" class="form-control" id="nombreFondo" placeholder="Nombre del Fondo" name="nombre_fondo" required>
            </div>
            <div class="form-group col-md-6">
                <label for="categoria">Categoría</label>
                <select class="form-control" id="categoria" name="categoria">
                    <option value="Renta Fija">Renta Fija</option>
                    <option value="Renta Variable">Renta Variable</option>
                    <option value="Internacional">Internacional</option>
                    <option value="Emergentes">Emergentes</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="valorInversion">Valor de la Inversión</label>
                <input type="number" class="form-control" id="valorInversion" placeholder="Valor de la Inversión" name="valor_inversion" required>
            </div>
            <div class="form-group col-md-4">
                <label for="fechaInversion">Fecha de Inversión</label>
                <input type="date" class="form-control" id="fechaInversion" name="fecha_inversion" required>
            </div>
            <div class="form-group col-md-4">
                <label for="rentabilidadEsperada">Rentabilidad Esperada</label>
                <input type="text" class="form-control" id="rentabilidadEsperada" placeholder="Rentabilidad Esperada" name="rentabilidad_esperada" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mr-3" name="enviar">Crear</button>
        <input type="reset" value="Limpiar" class="btn btn-success mr-3">
        <a href="inversiones.php" class="btn btn-info mr-3">Volver</a>
    </form>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger h-100 mt-3">
            <p><?php echo e($error); ?></p>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>