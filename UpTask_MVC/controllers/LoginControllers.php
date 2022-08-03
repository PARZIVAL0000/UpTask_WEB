<?php namespace Controllers;

use Mail\Mail;
use Model\Usuarios;
use MVC\Router;

    class LoginControllers{

        public static function login(Router $router){
            $alertas = [];
            if($_SERVER["REQUEST_METHOD"] === "POST"){
              
                $usuario = new Usuarios($_POST);
                $alertas = $usuario->ValidarLogin();
                if(empty($alertas)){
                    //verificar si el email colocado existe.
                    $usuario = Usuarios::where('Email', $usuario->Email);
                    if(!$usuario || !$usuario->Confirmado){
                        Usuarios::setAlerta('error', 'El correo electrónico insertado no está registrado o tu cuenta aún no ha sido confirmada.');
                    }else{
                        //verificar por el password colocado.
                        $diagnostico = $usuario->PasswordLogin($_POST['Password']);
                        if($diagnostico){
                            Usuarios::setAlerta('exito', 'Exito en el inicio se sesión');

                            session_start();
                          
                            
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['Nombre'] = $usuario->Nombre;
                            $_SESSION['Email'] = $usuario->Email;
                            $_SESSION['login'] = true;

                            header('location: /dashboard');
                            //Generar algunas configuraciones para la sesión.
                        }
                    }
                }
            }

            $alertas = Usuarios::getAlertas();
            $router->render('auth/login', [
                'titulo' => 'Iniciar Sesión',
                'alertas' => $alertas
            ]);
        }

        public static function logout(){
            session_start();
            $sesion = $_SESSION = [];
            if(empty($sesion)){
                header('location: /');
            }
        }

        //creación de una nueva cuenta...
        public static function create(Router $router){
            $usuario = new Usuarios();
            $alertas = [];
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuario->sincronizar($_POST);

                $alertas = $usuario->validarNuevaCuenta();
            
                if(empty($alertas)){
                    $existeUsuario = Usuarios::where('Email', $usuario->Email);

                    if($existeUsuario){
                        Usuarios::setAlerta('error', 'Hemos encontrado un usario ya registrado');
                        $alertas = Usuarios::getAlertas();
                    }else{
                         //crear usuario
                        $cliente = new Usuarios();
                        $cliente->sincronizar($usuario);
                         //hashear password.
                        $cliente->PassHash();
                        //Eliminar password2...
                        unset($cliente->PassConfirmar);
                        
                        //generar token
                        $cliente->Token();
                    
                        $resultado = $cliente->guardar();

                        $email = new Mail($cliente->Nombre, $cliente->Email, $cliente->Token);
                        $email->EmailSend();


                        if($resultado){
                            header('location: /mensaje');
                        }
                    }
                }
            }

            $router->render('auth/crear', [
                'titulo' => 'Crear cuenta',
                'usuario' => $usuario,
                'alertas' => $alertas,
            ]);

        }

        //El usuario inserta su email para poder enviarle un mensaje de crear nuevo password...
        public static function forget(Router $router){
            $alertas = [];
            $usuario = new Usuarios();
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarForget();

                if(empty($alertas)){
                    //comprobar que el email ya existe... para 
                    //poder hacer un cambio
                    $usuario = Usuarios::where('Email', $usuario->Email);

                    if($usuario && $usuario->Confirmado === "1"){
                        //generamos el token con la funcion.
                        $usuario->Token();
                        //eliminamos la funcion PassConfirmar.
                        unset($usuario->PassConfirmar);
                        //actualizamos al usuario.
                        $resultado = $usuario->guardar();

                        $mail = new Mail($usuario->Nombre, $usuario->Email, $usuario->Token);
                        $mail->EmailForget();

                        if($resultado){
                            Usuarios::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                        }
                    }else{
                        Usuarios::setAlerta('error', 'El usuario no existe o no está confirmado');
                    }
                }
            }

            $alertas = Usuarios::getAlertas();
            $router->render('auth/olvide',[
                'titulo' => 'Olvide Password',
                'alertas' => $alertas,
            ]);
        }

        //generar la creación de un nuevo password para poder tener nuevamente
        //acceso a nuestra cuenta de UpTask.
        public static function restablecer(Router $router){
            $alertas = [];
            $token = s($_GET["token"] ?? '');
            $resultado = false;
            if(!$token){
                header('location: /');
            }

            //hacer una consulta a DB con el token.
            $usuario = Usuarios::where('Token', $token);
            if(!$usuario){
                Usuarios::setAlerta('error', 'Token no válido');
                $resultado = true;
            }

            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuario->sincronizar($_POST);
                $alertas = $usuario->ValidarRestablecer();

                if(empty($alertas)){
                    $usuario->PassHash();
                    $usuario->Token = '';
                    unset($usuario->PassConfirmar);
                    $respuesta = $usuario->guardar();
                    if($respuesta){
                        header('location: /');
                    }
                }
            }
            $alertas = Usuarios::getAlertas();
            $router->render('auth/reestablecer', [
                'titulo' => 'Reestablecer Password',
                'alertas' => $alertas,
                'resultado' => $resultado
            ]);
        }

        public static function message(Router $router){

            $router->render('auth/mensaje', [
                'titulo' => 'Cuenta creada correctamente'
            ]);
        }


        //confirmacion por token de nuestra cuenta que creamos.
        public static function confirmation(Router $router){
            $alertas = [];
            $id = s($_GET['token'] ?? '');

            if(!$id){
                header('location: /');;
            }

            $usuarioExiste = Usuarios::where('Token', $id);
            if($usuarioExiste){
                Usuarios::setAlerta('exito', 'Cuenta Confirmada Correctamente');
                $usuarioExiste->Token = "";
                $usuarioExiste->Confirmado = 1;
                unset($usuarioExiste->PassConfirmar);  
                $respuesta = $usuarioExiste->guardar();
                
            }else{
                Usuarios::setAlerta('error', 'Identificador de cuenta incorrecto');
            }
            
            $alertas = Usuarios::getAlertas();
            $router->render('auth/confirmacion', [
                'titulo' => 'Confirma tu cuenta UpTask',
                'alertas' => $alertas,

            ]);
        }
    }
?>