<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\ProductosController;
use Controllers\AgendaController;
use Controllers\GaleriaController;
use Controllers\ServiciosController;
use Controllers\ClientesController;
use Controllers\PaginasController;
use Controllers\CategoriaServicioController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//***************AREA DE ADMINISTRACION**************//

$router->get('/admin/dashboard', [DashboardController::class, 'index']);

// Clientes
$router->get('/admin/clientes', [ClientesController::class, 'index']);
$router->get('/admin/clientes/crear', [ClientesController::class, 'crear']);
$router->post('/admin/clientes/crear', [ClientesController::class, 'crear']);
$router->get('/admin/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/admin/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/admin/clientes/eliminar', [ClientesController::class, 'eliminar']);

// productos
$router->get('/admin/productos', [ProductosController::class, 'index']);
$router->get('/admin/productos/crear', [ProductosController::class, 'crear']);
$router->post('/admin/productos/crear', [ProductosController::class, 'crear']);
$router->get('/admin/productos/editar', [ProductosController::class, 'editar']);
$router->post('/admin/productos/editar', [ProductosController::class, 'editar']);
$router->post('/admin/productos/eliminar', [ProductosController::class, 'eliminar']);

// servicios
$router->get('/admin/servicios', [ServiciosController::class, 'index']);
$router->get('/admin/servicios/crear', [ServiciosController::class, 'crear']);
$router->post('/admin/servicios/crear', [ServiciosController::class, 'crear']);
$router->get('/admin/servicios/editar', [ServiciosController::class, 'editar']);
$router->post('/admin/servicios/editar', [ServiciosController::class, 'editar']);
$router->post('/admin/servicios/eliminar', [ServiciosController::class, 'eliminar']);

$router->get('/admin/categoria-servicios', [CategoriaServicioController::class, 'verCategoria']);
$router->get('/admin/categoria-servicios/crear', [CategoriaServicioController::class, 'crear']);
$router->post('/admin/categoria-servicios/crear', [CategoriaServicioController::class, 'crear']);
$router->get('/admin/categoria-servicios/editar', [CategoriaServicioController::class, 'editar']);
$router->post('/admin/categoria-servicios/editar', [CategoriaServicioController::class, 'editar']);
$router->post('/admin/categoria-servicios/eliminar', [CategoriaServicioController::class, 'eliminar']);

// Agenda
$router->get('/admin/agenda', [AgendaController::class, 'index']);
$router->get('/admin/agenda/crear', [AgendaController::class, 'crear']);
$router->post('/admin/agenda/crear', [AgendaController::class, 'crear']);
$router->get('/admin/agenda/editar', [AgendaController::class, 'editar']);
$router->post('/admin/agenda/editar', [AgendaController::class, 'editar']);
$router->post('/admin/agenda/eliminar', [AgendaController::class, 'eliminar']);

// Galeria
$router->get('/admin/galeria', [galeriaController::class, 'index']);
$router->get('/admin/galeria/crear', [galeriaController::class, 'crear']);
$router->post('/admin/galeria/crear', [galeriaController::class, 'crear']);
$router->get('/admin/galeria/editar', [galeriaController::class, 'editar']);
$router->post('/admin/galeria/editar', [galeriaController::class, 'editar']);
$router->post('/admin/galeria/eliminar', [galeriaController::class, 'eliminar']);

$router->get('/api/productos', [PaginasController::class, 'obtenerProducto']);

//***************AREA PUBLICA**************//

$router->get('/', [PaginasController::class, 'index']);
$router->get('/catalogo', [PaginasController::class, 'catalogo']);
$router->get('/servicios', [PaginasController::class, 'servicios']);
$router->get('/categoria', [PaginasController::class, 'verCategoria']);
$router->get('/galeria', [PaginasController::class, 'galeria']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);



$router->comprobarRutas();