<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginControllers;
use Controllers\DashboardControllers;
use Controllers\TaskControllers;

$router = new Router();

//Login
$router->get('/', [LoginControllers::class, 'login']);
$router->post('/', [LoginControllers::class, 'login']);
$router->get('/logout', [LoginControllers::class, 'logout']);

//Crear Cuenta
$router->get('/crear', [LoginControllers::class, 'create']);
$router->post('/crear', [LoginControllers::class, 'create']);

//Formulario de olvide mi password.
$router->get('/forget', [LoginControllers::class, 'forget']);
$router->post('/forget', [LoginControllers::class, 'forget']);

//colocar nuevo password.
$router->get('/reestablecer', [LoginControllers::class, 'restablecer']);
$router->post('/reestablecer', [LoginControllers::class, 'restablecer']);

//Confirmacion
$router->get('/mensaje', [LoginControllers::class, 'message']);
$router->get('/confirmacion', [LoginControllers::class, 'confirmation']);

//=======================================================================
//                              RUTAS PRIVADAS
//=======================================================================
$router->get('/dashboard', [DashboardControllers::class, 'index']);
$router->get('/crear-proyecto', [DashboardControllers::class, 'madeProyect']);
$router->post('/crear-proyecto', [DashboardControllers::class, 'madeProyect']);
$router->get('/proyecto', [DashboardControllers::class, 'proyect']);
$router->get('/perfil', [DashboardControllers::class, 'perfil']);
$router->post('/perfil', [DashboardControllers::class, 'perfil']);
$router->get('/cambiar-password', [DashboardControllers::class, 'modificarPassword']);
$router->post('/cambiar-password', [DashboardControllers::class, 'modificarPassword']);


//======================================================================--
//                          API PARA LAS TAREAS
//=======================================================================
$router->get('/api/tareas', [TaskControllers::class, 'index']);
$router->post('/api/tarea', [TaskControllers::class, 'crear']);
$router->post('/api/tarea/actualizar', [TaskControllers::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [TaskControllers::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
