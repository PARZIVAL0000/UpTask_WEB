<div class="contenedor forget">
    <?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php';?>

        <form action="/forget" class="formulario" method="POST" novalidate>
            
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" 
                        id="email" 
                        name="Email" 
                        placeholder="Tu Email"
                />
            </div>
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
    </div>
</div>