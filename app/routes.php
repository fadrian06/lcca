<?php

use LCCA\App;
use LCCA\Controllers\AccountRegistrationController;
use LCCA\Controllers\EnrollmentController;
use LCCA\Controllers\HomeController;
use LCCA\Controllers\LoginController;
use LCCA\Middlewares\EnsureUserIsLoggedMiddleware;
use LCCA\Middlewares\EnsureUserIsNotLoggedMiddleware;

App::route('/salir', [LoginController::class, 'handleLogout']);

App::group('/perfil/recuperar(/@idCard:[0-9]+)', function (): void {
  App::route('GET /', [LoginController::class, 'showRecover']);
  App::route('POST /', [LoginController::class, 'checkAnswer']);
  App::route('POST /cambiar-clave', [LoginController::class, 'recoverPassword']);
}, [EnsureUserIsNotLoggedMiddleware::class]);

App::group('/ingresar', function (): void {
  App::route('GET /', [LoginController::class, 'showLogin']);
  App::route('POST /', [LoginController::class, 'handleLogin']);
}, [EnsureUserIsNotLoggedMiddleware::class]);

App::group('/registrarse', function (): void {
  App::route('GET /', [AccountRegistrationController::class, 'showRegistration']);
  App::route('POST /', [AccountRegistrationController::class, 'handleRegistration']);
});

App::group('', function (): void {
  App::route('GET /', [HomeController::class, 'showHome']);

  App::group('/inscribir', function (): void {
    App::route('GET /', [EnrollmentController::class, 'showEnrollmentForm']);
    App::route('POST /', [EnrollmentController::class, 'handleNewEnrollment']);
  });
}, [EnsureUserIsLoggedMiddleware::class]);
