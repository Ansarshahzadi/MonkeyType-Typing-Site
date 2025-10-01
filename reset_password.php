<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>AeroPage - Bootstrap 5 Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap 5 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
  </head>
  <body class="bg-white text-dark">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-7">
            <div class="card shadow-lg border-0 rounded-3">
              <div class="card-body p-4">
                <!-- Logo -->
                <div class="text-center mb-4">
                  <a href="index.html">
                    <img
                      src="assets/logo-light-82928a21.png"
                      style="height: 40px"
                      alt="logo"
                    />
                  </a>
                </div>

                <!-- Heading -->
                <h4 class="text-center mb-4 fw-bold">Reset Password</h4>

                <!-- Form -->
                <form class="needs-validation" novalidate>
                  <!-- New Password -->
                  <div class="mb-3">
                    <label for="newPassword" class="form-label"
                      >New Password</label
                    >
                    <div class="input-group">
                      <input
                        type="password"
                        id="newPassword"
                        class="form-control border-dark"
                        placeholder="Enter new password"
                        required
                        minlength="6"
                      />
                      <button
                        class="btn btn-outline-dark toggle-password"
                        type="button"
                      >
                        <i class="bi bi-eye"></i>
                      </button>
                      <div class="invalid-feedback">
                        Please enter a new password (min 6 characters).
                      </div>
                    </div>
                  </div>

                  <!-- Confirm Password -->
                  <div class="mb-3">
                    <label for="confirmPassword" class="form-label"
                      >Confirm New Password</label
                    >
                    <div class="input-group">
                      <input
                        type="password"
                        id="confirmPassword"
                        class="form-control border-dark"
                        placeholder="Confirm new password"
                        required
                      />
                      <button
                        class="btn btn-outline-dark toggle-password"
                        type="button"
                      >
                        <i class="bi bi-eye"></i>
                      </button>
                      <div class="invalid-feedback">
                        Passwords do not match.
                      </div>
                    </div>
                  </div>

                  <!-- Submit -->
                  <div class="d-grid gap-2 mb-4">
                    <button
                      type="submit"
                      class="btn text-white fw-bold"
                      style="background-color: rgb(234 88 12)"
                    >
                      Reset Password
                    </button>
                  </div>
                </form>

                <!-- Footer -->
                <p class="text-center">
                  Back to
                  <a href="index.html" class="text-danger fw-bold"
                    >Login</a
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation + Toggle Script -->
    <script>
      // Bootstrap validation
      (function () {
        "use strict";
        const forms = document.querySelectorAll(".needs-validation");
        Array.from(forms).forEach(function (form) {
          form.addEventListener(
            "submit",
            function (event) {
              const newPass = document.getElementById("newPassword");
              const confirmPass = document.getElementById("confirmPassword");

              if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
              }

              if (newPass.value !== confirmPass.value) {
                event.preventDefault();
                event.stopPropagation();
                confirmPass.setCustomValidity("Passwords do not match");
              } else {
                confirmPass.setCustomValidity("");
              }

              form.classList.add("was-validated");
            },
            false
          );
        });
      })();

      // Password show/hide toggle
      document.querySelectorAll(".toggle-password").forEach((btn) => {
        btn.addEventListener("click", function () {
          let input = this.previousElementSibling;
          let icon = this.querySelector("i");
          if (input.type === "password") {
            input.type = "text";
            icon.classList.replace("bi-eye", "bi-eye-slash");
          } else {
            input.type = "password";
            icon.classList.replace("bi-eye-slash", "bi-eye");
          }
        });
      });
    </script>
  </body>
</html>
