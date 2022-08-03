
<div class="contenedor crear">
    <?php include_once __DIR__.'/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/crear" class="formulario" method="POST">
            <div class="campo">
                <label for="Nombre">Nombre:</label>
                <input type="text" 
                        id="Nombre" 
                        name="Nombre" 
                        placeholder="Nombre y Apellido"
                        value="<?php echo s($usuario->Nombre); ?>"
                />
            </div>
            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" 
                        id="email" 
                        name="Email" 
                        placeholder="Tu Email"
                        value="<?php echo s($usuario->Email); ?>"
                />
            </div>
            <div class="campo">
                <label for="password">Password:</label>
                <input type="password" 
                    id="password" 
                    name="Password" 
                    placeholder="Recomendamos que tu password también contenga números"
                    />
            </div>
            <div class="campo">
                <label for="pass">Confirmar Password:</label>
                <input type="password" 
                        id="pass" 
                        name="PassConfirmar" 
                        placeholder="Confirma nuevamente tu password"
                />
            </div>

            <input type="submit" class="boton" value="Crear cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
            <a href="/forget">¿Olvidaste tu password? Recuperar password</a>
        </div>
    </div>
</div>