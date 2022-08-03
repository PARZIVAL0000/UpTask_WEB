<aside class="sidebar">
    <div class="contenedor-sidebar">  
        <h2>UpTask</h2>
        <div class="cerrar-menu">
            <img src="build/img/cerrar.svg" id="cerrar-menu" alt="cerrar-menu">
        </div>
    </div>


    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === "Tu portafolio") ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === "Crear proyecto") ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === "Perfil") ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>

    <div class="cerrar-sesion-mobil">
        <a href="/logout" class="cerrarSesion">Cerrar Sesión</a>
    </div>
</aside>