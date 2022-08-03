<div class="barra-mobile">
    <h1>UpTask</h1>
    
    

    <div class="menu">
        <img src="build/img/menu.svg" id="mobile-menu" alt="barra-menu">
    </div>
</div>

<div class="barra">
    <p>Hola : <span><?php 
    echo $_SESSION['Nombre']; ?></span></p>

    <a href="/logout" class="cerrarSesion">Cerrar Sesión</a>
</div>