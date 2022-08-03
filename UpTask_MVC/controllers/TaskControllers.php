<?php namespace Controllers; 

use Model\Proyectos;
use Model\Tareas;

    class TaskControllers{

        //traernos todas las tareas relacionadas con un proyecto
       public static function index(){
        
            $url = $_GET['id'];
            //cuando no deje de existir una url...
            if(!$url) header('location: /dashboard');
            // extraer el proyecto creado por el usuario...
            $proyecto = Proyectos::where('Url', $url);
            
            session_start();
            //solo cuando no haiga existencia de un proyecto o de que no sean los mismos propietarios...
            if(!$proyecto || $proyecto->PropietarioId !== $_SESSION['id'] || is_null($proyecto->PropietarioId) || is_null($_SESSION['id'])){
                header('location: /404');
            }
           
            $tarea = Tareas::belongsTo('ProyectoId', $proyecto->id);
            
            echo json_encode([
                'tarea' => $tarea
            ]);
       }

       public static function crear(){
            session_start();
            isLogin();

            if($_SERVER['REQUEST_METHOD'] === "POST"){
                //la tarea creada por el usuario para su proyecto.
                $proyectoId = $_POST['ProyectoId'];

                $proyecto = Proyectos::where('Url', $proyectoId);

               if(!$proyecto || $proyecto->PropietarioId !== $_SESSION['id']){
                    $respuesta = [
                        'tipo' => 'error', 
                        'mensaje' => 'Hubo un error en el agrego de tu tarea'
                    ];
                    echo json_encode($respuesta);
                    return;
               }
                //Todo bien, crear e instanciar la Tarea del usuario.
                $task = new Tareas($_POST);
                $task->ProyectoId = $proyecto->id;
                $resultado = $task->guardar();
                $respuesta = [
                    'tipo' => 'exito', 
                    'id' => $resultado['id'],
                    'mensaje' => 'Tarea creada correctamente', 
                    'ProyectoId' =>  $proyecto->id

                ];
                echo json_encode($respuesta);
            }
       }

       public static function actualizar(){
            $tsk = new Tareas();
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                session_start();
                //validar que el proyecto exista. (Como capa de seguridad demás)
                $proyecto = Proyectos::where('Url', $_POST['ProyectoId']);
                
                if(!$proyecto || $proyecto->PropietarioId !== $_SESSION['id']){
                    $respuesta = [
                        'tipo' => 'error', 
                        'mensaje' => 'Hubo un error en la actualización'
                    ];
                    echo json_encode($respuesta);
                    return;
                }
                
                $tsk->sincronizar($_POST);
                $tsk->ProyectoId = $proyecto->id;
                $save = $tsk->guardar();
                if($save){
                    $respuesta = [
                        'tipo' => 'exito', 
                        'id' => $tsk->id,
                        'ProyectoId' =>  $proyecto->id, 
                        'mensaje' => 'Actualizado correctamente'
                    ];

                    echo json_encode(['rslt' => $respuesta]);
                }

            //    echo json_encode($respuesta);
            }
       }

       public static function eliminar(){
            //eliminar la tarea creada.
            $tarea = new Tareas();
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                session_start();
                //verificar que el proyecto exista.
                $proyecto = Proyectos::where('Url', $_POST['ProyectoId']);

            
                if(!$proyecto || $proyecto->PropietarioId !== $_SESSION['id']){
                    $respuesta = [
                        'tipo' => 'error',
                        'mensaje' => 'Hay un error'
                    ];
                    echo json_encode($respuesta);
                    return;
                }

                $tarea->sincronizar($_POST);
                $rslt = $tarea->eliminar();

                $resultado = [ 
                    'resultado' => $rslt,
                    'mensaje' => 'Tarea eliminada correctamente',
                ];

                echo json_encode($resultado);
            }
       }

    }

?>