<?php include_once __DIR__ . '/header-dashboard.php' ?>

<!-- La información importante y única de nosotros... -->
<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar mi password >>></a>

    <form action="/perfil" method="POST" class="formulario">
        <div class="campo">
            <label for="Nombre">Nombre</label>
            <input type="text" 
                    id="Nombre" 
                    name="Nombre" 
                    placeholder="Nombre del usuario activo" 
                    value="<?php echo s($usuario->Nombre); ?>"/>
        </div>
        <div class="campo">
            <label for="Email">Email</label>
            <input type="email"
                    id="Email" 
                    name="Email" 
                    placeholder="Email del usuario activo" 
                    value="<?php echo s($usuario->Email); ?>"/>
        </div>
        <input type="submit" value="Guardar Cambios">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>
  