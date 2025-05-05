<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'login'; // پیش‌فرض لاگین
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login or Register</title>
  <!-- CUSTOM CSS -->
  <link rel="stylesheet" href="<?= assets('style/style.css') ?>">
  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="<?= BASE_URL . "/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" ?>"> -->

</head>

<body>
  <div class="container <?= $action === 'register' ? 'sign-up-mode' : '' ?>">
    <div class="forms-container">

      <div class="signin-signup">
        <!-- Login Form -->
        <form action="<?= siteUrl('auth.php?action=login') ?>" class="sign-in-form" method="post">
          <h2 class="title">Login</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" autocomplete="email" placeholder="email" required>
          </div>
          <!-- <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="contraseña" autocomplete="current-password" placeholder="Password" id="id_password" required>
            <i class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
          </div> -->
          <input type="submit" value="Sign in" class="btn solid">
          <div class="social-media">
            <a class="icon-mode" onclick="toggleTheme('dark');"><i class="fas fa-moon"></i></a>
            <a class="icon-mode" onclick="toggleTheme('light');"><i class="fas fa-sun"></i></a>
          </div>
          <p class="text-mode">Change theme</p>
        </form>
        <?php if (!empty($_SESSION['error'])) :  ?>
          <span class="mb-4 opacity-70" style="color: red;">
            <?= $_SESSION['error']; ?>
          </span>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="<?= siteUrl('auth.php?action=register'); ?>" class="sign-up-form" method="post">
          <h2 class="title">Register</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="name" autocomplete="name" placeholder="Username">
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" autocomplete="email" placeholder="Email">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="phone" name="phone" placeholder="phone" id="id_reg">
            <i class="far fa-eye" id="toggleReg" style="cursor: pointer;"></i>
          </div>
          <label class="check">
            <input type="checkbox">
            <span class="checkmark">I accept the <a href="terms.html">terms and services</a></span>
          </label>
          <input type="submit" value="Create account" class="btn solid">
        </form>
      </div>
    </div>

    <!-- Panels -->
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>You don't have an account?</h3>
          <p>Create your account right now to follow people and like publications</p>
          <button class="btn transparent" id="sign-up-btn">Register</button>
        </div>
        <img src="img/log.svg" class="image" alt="">
      </div>

      <div class="panel right-panel">
        <div class="content">
          <h3>Already have an account?</h3>
          <p>Login to see your notifications and post your favorite photos</p>
          <button class="btn transparent" id="sign-in-btn">Sign in</button>
        </div>
        <img src="img/register.svg" class="image" alt="">
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <!-- <script src="<?= BASE_URL . "/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js" ?>"></script> -->

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const container = document.querySelector(".container");
      const signInBtn = document.querySelector("#sign-in-btn");
      const signUpBtn = document.querySelector("#sign-up-btn");

      signUpBtn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
        history.pushState(null, '', '?action=register');
      });

      signInBtn.addEventListener("click", () => {
        container.classList.remove("sign-up-mode");
        history.pushState(null, '', '?action=login');
      });
    });
  </script>
  <script src="assets/js/script.js"></script>
</body>

</html>