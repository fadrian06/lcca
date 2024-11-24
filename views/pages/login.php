<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form method="post" class="my-5">
        <div class="border border-dark rounded-2 p-4 mt-5">
          <div class="login-form">
            <a href="./" class="mb-4 d-flex">
              <img src="./assets/images/logo-sm.svg" height="48" />
            </a>
            <h5 class="fw-light mb-5">
              Introduce tus credenciales para acceder al sistema.
            </h5>
            <div class="mb-3">
              <label class="form-label">Tu cédula</label>
              <input
                type="number"
                name="idCard"
                required
                class="form-control"
                placeholder="Introduce tu cédula" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu contraseña</label>
              <input
                type="password"
                name="password"
                required
                class="form-control"
                placeholder="Introduce tu contraseña" />
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a
                href="./perfil/recuperar"
                class="text-blue text-decoration-underline">
                ¿Olvidó su contraseña?
              </a>
            </div>
            <div class="d-grid py-3 mt-4">
              <button type="submit" class="btn btn-lg btn-primary">
                Ingresar
              </button>
            </div>
            <div class="text-center pt-4">
              <span>¿No tienes cuenta?</span>
              <a
                href="./registrarse"
                class="text-blue text-decoration-underline ms-2">
                Crea una
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
