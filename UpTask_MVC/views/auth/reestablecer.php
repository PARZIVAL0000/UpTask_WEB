<div class="contenedor reestablecer">
    <?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?> 

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>

        <?php include_once __DIR__. '/../templates/alertas.php';?>
        <?php if($resultado)return;  ?> 

        <form class="formulario" method="POST">
            <div class="campo">
                <label for="Password">Nuevo Password:</label>
                <input type="password" 
                        id="Password" 
                        name="Password" 
                        placeholder="Tu nuevo password"
                />
            </div>
            <input type="submit" class="boton" value="Guardar Password">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
    </div>
</div>