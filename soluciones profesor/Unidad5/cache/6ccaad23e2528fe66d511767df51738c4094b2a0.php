<?php $__env->startSection('titulo'); ?>
    <?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('encabezado'); ?>
    <?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>
    <?php if(isset($mensaje)): ?>
        <div >
            <p><?php echo e($mensaje); ?></p>
        </div>
    <?php endif; ?>
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
        <?php $__currentLoopData = $inversiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($inversion->nombre_fondo); ?></td>
                <td><?php echo e($inversion->categoria); ?></td>
                <td><?php echo e($inversion->valor_inversion); ?></td>
                <td><?php echo e($inversion->fecha_inversion); ?></td>
                <td><?php echo e($inversion->rentabilidad_esperada); ?>%</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('plantillas.plantilla1', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>