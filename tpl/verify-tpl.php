<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Bootstrap 5 verify OTP with validation form inputs</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/style/verify.css" />
</head>

<body>
  <!-- partial:index.partial.html -->
  <div
    class="container height-100 d-flex justify-content-center align-items-center">
    <div class="position-relative">
      <div class="card p-2 text-center">
        <h6>
          Please enter the one time password <br />
          to verify your account
        </h6>
        <div>
          <span>A code has been sent to</span>
          <small id="maskedNumber">*******9897</small>
        </div>
        <form action="<?= siteUrl('auth.php?action=verify') ?>" method="POST">
          <div class="input-group mt-4">
            <input type="text" name="token" class="form-control"
              placeholder="Enter OTP" required />
          </div>

          <div class="mt-4">
            <button id="validateBtn" type="submit" class="btn btn-danger px-4 validate">
              Validate
            </button>
        </form>
      </div>
    </div>
  </div>
  </div>
  <?php if (!empty($_SESSION['error'])) :  ?>
    <span class="mb-4 opacity-70" style="color: red;">
      <?= $_SESSION['error']; ?>
    </span>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
  <!-- partial -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.min.js"></script>
  <!-- <script src="assets/js/verify.js"></script> -->
</body>

</html>