<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form method="post" class="my-5">
        <div class="border border-dark rounded-2 p-4 mt-5">
          <div class="login-form">
            <a href="./" class="mb-4 d-flex">
              <img src="./assets/images/logo.svg" class="img-fluid login-logo" alt="Mercury Admin" />
            </a>
            <h5 class="fw-light mb-5">Introduce tus credenciales para acceder al sistema.</h5>
            <div class="mb-3">
              <label class="form-label">Tu correo</label>
              <input type="email" name="email" required class="form-control" placeholder="Introduce tu correo" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu contraseña</label>
              <input type="password" name="password" required class="form-control" placeholder="Introduce tu contraseña" />
            </div>
            <!-- <div class="d-flex align-items-center justify-content-between">
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" value="" id="rememberPassword" />
                <label class="form-check-label" for="rememberPassword">Remember</label>
              </div>
              <a href="forgot-password.html" class="text-blue text-decoration-underline">Lost password?</a>
            </div> -->
            <div class="d-grid py-3 mt-4">
              <button type="submit" class="btn btn-lg btn-primary">
                Ingresar
              </button>
            </div>
            <!-- <div class="text-center py-3">or Login with</div>
            <div class="d-flex gap-2 justify-content-center">
              <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-google me-2"></i>Gmail
              </button>
              <button type="submit" class="btn btn-outline-info">
                <i class="bi bi-facebook me-2"></i>Facebook
              </button>
            </div> -->
            <div class="text-center pt-4">
              <span>¿No tienes cuenta?</span>
              <a href="./registrarse" class="text-blue text-decoration-underline ms-2">
                Crea una
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
