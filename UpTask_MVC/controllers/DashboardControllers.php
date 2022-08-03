<?php namespace Controllers;

use MVC\Router;
use Model\Proyectos;
use Model\Usuarios;

    class DashboardControllers {
        public static function index(Router $router){
            //crea la sesión y nuevamente la valida.
            session_start();
            islogin();

            $id = $_SESSION['id'];
            //todos los proyectos de nuestro usuario
            $proyectos = Proyectos::belongsTo('PropietarioId', $id);

            $router->render('dashboard/index', [
                'titulo' => 'Tu portafolio',
                'proyectos' => $proyectos
                
            ]);
        }

        public static function madeProyect(Router $router){
            //crear la sesión nuevamente y la valida.
            session_start();
            islogin();

            //================
            $alertas =  [];

            $proyecto = new Proyectos();

            if($_SERVER['REQUEST_METHOD'] === "POST"){
                $proyecto->sincronizar($_POST);
                //validación.
                $alertas = $proyecto->validacionProyect();

                if(empty($alertas)){
                    //Generar una URL única.
                    $proyecto->Url = md5(uniqid());

                    //Almacenar el creador del proyecto.
                    $proyecto->PropietarioId = $_SESSION['id'];

                    //Guardar el proyecto de nuestro usuario.
                    $proyecto->guardar();

                    //redireccionar.
                    header("location: /proyecto?id={$proyecto->Url}");
                }
            }

            $router->render('dashboard/crear_proyecto', [
                'titulo' => 'Crear proyecto',
                'alertas' => $alertas,
            ]);
        }

        public static function proyect(Router $router){
            //crear la sesión y validar el login.
            session_start();
            isLogin();

            //Asegurar que la persona que visita el proyecto, es quien lo creó.
            $token = $_GET['id'];

            if(!$token)header('location: /dashboard');

            //consulta a la DB para validar proyecto
            $proyecto = Proyectos::where('Url', $token);

            if($_SESSION['id'] !== $proyecto->PropietarioId){
                header('location: /dashboard');
            }

            $router->render('dashboard/proyecto', [
                'titulo' => $proyecto->Proyecto
            ]);
        }

        public static function perfil(Router $router){
            //crea la sesión nuevamente y la valida.
            session_start();
            islogin();

            //buscaremos por nuestro usuario.
            $usuario = Usuarios::find($_SESSION['id']);
            //generamos vacío las alertas.
            $alertas = [];

            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuario->sincronizar($_POST);
                $alertas = $usuario->ValidarPerfil();

                // debuguear($usuario);
                if(empty($alertas)){
                    //verificar que el email del usuario (ACTUALIZADO) no sea repetido o 
                    // que sea igual de otro usuario...
                    $existeUsuario = Usuarios::where('Email', $usuario->Email);
                    
                    // debuguear($existeUsuario);
                    //Verificar si el email introducido ya existe o no
                    if($existeUsuario && $existeUsuario->id !== $usuario->id){
                        //si el Email encontrado en la DB existe, lo verificaremos junto con la sesión.
                        Usuarios::setAlerta('error', 'La cuenta ya pertenece al de un usuario registrado.');
                        
                    }else{
                        $usuario->guardar();
                        Usuarios::setAlerta('exito', 'Actualizado correctamente');
                    }

                    $usuario->guardar();
                    $_SESSION['Nombre'] = $usuario->Nombre;

                }
                    
            }
                
            $alertas = Usuarios::getAlertas();
            $router->render('dashboard/perfil', [
                'titulo' => 'Perfil',
                'alertas' => $alertas,
                'usuario' => $usuario
            ]);
        }

        public static function modificarPassword(Router $router){
            session_start();
            isLogin();

            $alertas = [];

            //Datos del usuario registrado en la base de datos.
            $usuario = Usuarios::find($_SESSION['id']);

           
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $usuario->sincronizar($_POST);
               
                $alertas = $usuario->ValidarCamposPassword();

                if(empty($alertas)){
                    $respuesta = $usuario->PasswordLogin($usuario->Password_Actual);
                  
                    if(!$respuesta){
                        $alertas = Usuarios::getAlertas(); // -> llamando a la alerta "Password Incorrrecto".
                    }else{
                        unset($usuario->Password_Actual);
                        unset($usuario->PassConfirmar);
                        $usuario->Password = $usuario->HashPassNuevo();
                       $resultado = $usuario->guardar();

                        if($resultado){
                            Usuarios::setAlerta('exito', 'Password Actualizado Correctamente');
                            $alertas = Usuarios::getAlertas();
                        }
                    }
                }
            }

            
            $router->render('dashboard/cambiar_password', [
                'titulo' => 'Modificar password',
                'alertas' => $alertas
            ]);
        }
    }   

?>