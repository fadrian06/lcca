<?php

use LCCA\App;
use LCCA\Controllers\AccountRegistrationController;
use LCCA\Controllers\EnrollmentController;
use LCCA\Controllers\HomeController;
use LCCA\Controllers\LoginController;
use LCCA\Controllers\StudentController;
use LCCA\Controllers\SubjectController;
use LCCA\Controllers\TeacherController;
use LCCA\Controllers\UserProfileController;
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

  App::group('/perfil', function (): void {
    App::route(
      'GET /configurar',
      [UserProfileController::class, 'showConfigurations']
    );

    App::route(
      'POST /configurar',
      [UserProfileController::class, 'handleProfileInfoChange']
    );

    App::route(
      'POST /cambiar-clave',
      [UserProfileController::class, 'handlePasswordChange']
    );

    App::route(
      '/eliminar',
      [UserProfileController::class, 'deleteAccount']
    );
  });

  App::group('/docentes', function (): void {
    App::route('GET /', [TeacherController::class, 'showTeachers']);
    App::route('GET /registrar', [TeacherController::class, 'showAddTeacherPage']);

    App::route('POST /registrar', [
      TeacherController::class,
      'handleTeacherRegistration'
    ]);

    App::group('/@id:[\w]+', function (): void {
      App::route('POST /eliminar', [TeacherController::class, 'deleteTeacher']);
    });
  });

  App::group('/areas', function (): void {
    App::route('GET /', [SubjectController::class, 'showSubjects']);
    App::route('POST /', [SubjectController::class, 'addSubject']);

    App::group('/@id:[\w]+', function (): void {
      App::route('GET /editar', [SubjectController::class, 'showEditPage']);
      App::route('POST /editar', [SubjectController::class, 'handleEditSubject']);
      App::route('/eliminar', [SubjectController::class, 'deleteSubject']);
    });
  });

  App::group('/estudiantes', function (): void{
    App::route('GET /', [StudentController::class, 'showStudents']);
  });
}, [EnsureUserIsLoggedMiddleware::class]);
