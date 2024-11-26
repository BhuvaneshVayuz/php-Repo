<!-- application/views/navbar.php -->
<div class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="<?php echo base_url('user/index'); ?>" class="navbar-brand">CRUD APPLICATION - Profile</a>
        <div class="ml-auto">
            <a href="<?php echo base_url().'index.php/auth/logout'; ?>" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>
