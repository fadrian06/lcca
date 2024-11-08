<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-5 col-sm-6 col-12">
      <form method="post" class="my-5">
        <div class="border border-dark rounded-2 p-4 mt-5">
          <div class="login-form">
            <a href="./" class="mb-4 d-flex">
              <img src="./assets/images/logo.svg" class="img-fluid login-logo" alt="Mercury Admin" />
            </a>
            <h5 class="fw-light mb-5">Crea tu cuenta de administrador.</h5>
            <div class="mb-3">
              <label class="form-label">Tu nombre</label>
              <input
                name="name"
                required
                class="form-control"
                placeholder="Introduce tu nombre"
                pattern="[a-zA-ZáéíóúñÁÉÍÓÚÑ]{3,}"
                title="El nombre sólo puede tener mínimo 3 letras" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu correo</label>
              <input type="email" name="email" required class="form-control" placeholder="Introduce tu correo" />
            </div>
            <div class="mb-3">
              <label class="form-label">Tu contraseña</label>
              <input type="password" name="password" required minlength="8" class="form-control" placeholder="Introduce tu contraseña" />
            </div>
            <!-- <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" placeholder="Re-enter password" />
            </div> -->
            <!-- <div class="d-flex align-items-center justify-content-between">
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" value="" id="termsConditions" />
                <label class="form-check-label" for="termsConditions">I agree to the terms and conditions</label>
              </div>
            </div> -->
            <div class="d-grid py-3 mt-4">
              <button type="submit" class="btn btn-lg btn-primary">
                Crear cuenta
              </button>
            </div>
            <!-- <div class="text-center py-3">or Signup with</div>
            <div class="d-flex gap-2 justify-content-center">
              <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-google"></i>
              </button>
              <button type="submit" class="btn btn-outline-info">
                <i class="bi bi-facebook"></i>
              </button>
            </div> -->
            <div class="text-center pt-4">
              <span>¿Ya tienes una cuenta?</span>
              <a href="./ingresar" class="text-blue text-decoration-underline ms-2">
                Ingresa
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
