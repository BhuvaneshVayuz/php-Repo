<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
<div class="container bg-white p-5 rounded shadow">
        <h2 class="text-center mb-4">Sign In</h2>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>    <?php endif; ?>

    <form action="<?= site_url('auth/sign_in_submit'); ?>" method="post">
    <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

        <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
    </form>

    <p class="text-center mt-3">Don't have an account? <a href="<?= site_url('auth/sign_up'); ?>">Sign Up</a></p>
    </div>

</body>
</html>
