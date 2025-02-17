<?php

use LCCA\App;
use LCCA\Controllers\AccountRegistrationController;
use LCCA\Controllers\EnrollmentController;
use LCCA\Controllers\HomeController;
use LCCA\Controllers\LoginController;
use LCCA\Controllers\StudentController;
use LCCA\Controllers\StudyYearController;
use LCCA\Controllers\SubjectController;
use LCCA\Controllers\TeacherController;
use LCCA\Controllers\UserProfileController;
use LCCA\Enums\StudyYear;
use LCCA\Middlewares\EnsureUserIsActive;
use LCCA\Middlewares\EnsureUserIsCoordinator;
use LCCA\Middlewares\EnsureUserIsLogged;
use LCCA\Middlewares\EnsureUserIsNotLogged;

App::route('/salir', [LoginController::class, 'handleLogout']);

App::group('/perfil/recuperar(/@idCard:[0-9]+)', static function (): void {
  App::route('GET /', [LoginController::class, 'showRecover']);
  App::route('POST /', [LoginController::class, 'checkAnswer']);
  App::route('POST /cambiar-clave', [LoginController::class, 'recoverPassword']);
}, [EnsureUserIsNotLogged::class]);

App::group('/ingresar', static function (): void {
  App::route('GET /', [LoginController::class, 'showLogin']);
  App::route('POST /', [LoginController::class, 'handleLogin']);
}, [EnsureUserIsNotLogged::class]);

App::group('/registrarse', static function (): void {
  App::route('GET /', [AccountRegistrationController::class, 'showRegistration']);
  App::route('POST /', [AccountRegistrationController::class, 'handleRegistration']);
});

App::group('', static function (): void {
  App::route('GET /', [HomeController::class, 'showHome']);

  App::group('/inscribir', static function (): void {
    App::route('GET /', [EnrollmentController::class, 'showEnrollmentForm']);
    App::route('POST /', [EnrollmentController::class, 'handleNewEnrollment']);
  });

  App::group('/perfil', static function (): void {
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
      '/desactivar',
      [UserProfileController::class, 'disableAccount']
    );
  });

  App::group('/docentes', static function (): void {
    App::route('GET /', [TeacherController::class, 'showTeachers']);
    App::route('GET /registrar', [TeacherController::class, 'showAddTeacherPage']);

    App::route('POST /registrar', [
      TeacherController::class,
      'handleTeacherRegistration'
    ]);

    App::group('/@id:[\w]+', static function (): void {
      App::route('POST /eliminar', [TeacherController::class, 'deleteTeacher']);
    });
  });

  App::group('/areas', static function (): void {
    App::route('GET /', [SubjectController::class, 'showSubjects']);
    App::route('POST /', [SubjectController::class, 'addSubject']);

    App::group('/@id:[\w]+', static function (): void {
      App::route('GET /editar', [SubjectController::class, 'showEditPage']);
      App::route('POST /editar', [SubjectController::class, 'handleEditSubject']);
      App::route('/eliminar', [SubjectController::class, 'deleteSubject']);
    });
  });

  App::group('/estudiantes', static function (): void {
    App::route('GET /', [StudentController::class, 'showStudents']);

    App::group('/@studentId:\w+', static function (): void {
      App::route('GET /', [StudentController::class, 'showStudentProfile']);
      App::route('POST /', [StudentController::class, 'handleStudentUpdate']);
      App::route('GET /editar', [StudentController::class, 'showEditStudent']);
      App::route('GET /reinscribir', [EnrollmentController::class, 'showReEnrollForm']);
      App::route('POST /reinscribir', [EnrollmentController::class, 'handleReEnrollment']);
      App::route('POST /graduar', [StudentController::class, 'handleGraduation']);
      App::route('POST /retirar', [StudentController::class, 'handleRetirement']);

      App::group('/representantes/@representativeId:\w+', static function (): void {
        App::route('/desvincular', [StudentController::class, 'removeRepresentative']);
      });
    });
  });

  App::group('/años', static function (): void {
    App::route('GET /', [StudyYearController::class, 'showStudyYears']);

    App::group('/@id:\w+', static function (): void {
      App::route('POST /', [StudyYearController::class, 'handleUpdateStudyYear']);

      App::route(
        'POST /secciones',
        [StudyYearController::class, 'handleOpenSection']
      );
    });
  }, [EnsureUserIsCoordinator::class]);

  App::group('/secciones', static function (): void {
    App::group('/@id:\w+', static function (): void {
      App::route('GET /eliminar', [StudyYearController::class, 'deleteSection']);
      App::route('POST /', [StudyYearController::class, 'handleUpdateSection']);
    });
  });

  App::route('/respaldar', static function (): void {
    App::db()->backup();

    flash()->set('Base de datos respaldada exitósamente', 'success');
    App::redirect(App::request()->referrer);
  })->addMiddleware(EnsureUserIsCoordinator::class);

  App::route('/restaurar', static function (): void {
    App::restoreDb();

    flash()->set('Base de datos restaurada exitósamente', 'success');
    App::redirect('/salir');
  })->addMiddleware(EnsureUserIsCoordinator::class);
}, [EnsureUserIsLogged::class, EnsureUserIsActive::class]);

App::group('/api', static function (): void {
  App::group('/estudiantes', function (): void {
    App::route('GET /@idCard:[0-9]+', [StudentController::class, 'searchStudentByIdCard']);
    App::route('GET /@names:[a-zA-ZáéíóúÁÉÍÓÚñÑ]+', [StudentController::class, 'searchStudentByNames']);
  });
}, [EnsureUserIsLogged::class]);
