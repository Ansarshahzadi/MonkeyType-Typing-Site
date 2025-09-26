<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>AeroPage - Bootstrap 5 Recover Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap 5 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body class="bg-white text-dark">
  <div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
              <!-- Logo -->
              <div class="text-center mb-4">
                <a href="index.html">
                  <img
                    src="assets/img/logo.png"
                    style="height: 80px"
                    alt="logo" />
                </a>
              </div>

              <!-- Heading -->
              <h4 class="text-center mb-4 fw-bold">Recover Password</h4>

              <!-- Form -->
              <form class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="LogInEmailAddress" class="form-label">Email address</label>
                  <input
                    type="email"
                    id="LogInEmailAddress"
                    class="form-control border-dark"
                    placeholder="Enter your email"
                    required />
                  <div class="invalid-feedback">
                    Please enter a valid email address.
                  </div>
                </div>

                <div class="d-grid gap-2 mb-4">
                  <button
                    type="submit"
                    class="btn text-white fw-bold"
                    style="background-color: rgb(234 88 12)">
                    Reset Password
                  </button>
                  <a href="index.html" class="btn btn-outline-dark">Go to Login</a>
                </div>
              </form>

              <!-- Footer -->
              <p class="text-center">
                Already have an account?
                <a href="index.html" class="text-danger fw-bold">Login</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Validation Script -->
  <script>
    (() => {
      "use strict";
      const forms = document.querySelectorAll(".needs-validation");
      Array.from(forms).forEach((form) => {
        form.addEventListener(
          "submit",
          (event) => {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    })();
  </script>
</body>

</html>