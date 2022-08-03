<?php include_once __DIR__ . '/header-dashboard.php' ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace"><<< Volver a mi Perfil</a>

    <form action="/cambiar-password" method="POST" class="formulario">
        <div class="campo">
            <label for="Password">Password Actual</label>
            <input type="password" 
                    id="Password" 
                    name="Password_Actual" 
                    placeholder="Verificar Password"
                    />
        </div>
        <div class="campo">
            <label for="Password_Nuevo">Password Nuevo</label>
            <input type="password" 
                    id="Password_Nuevo" 
                    name="Password_Nuevo" 
                    placeholder="Password Nuevo"
                    />
        </div>
        
        <input type="submit" value="Actualizar password">
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>
  