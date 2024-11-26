<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>">
</head>
<body>
<?php $this->load->view('navbar'); ?>

<div class="container" style="padding-top: 10px;">
    <h3>Edit Profile</h3>
    <hr>
    <form method="post" action="<?php echo base_url().'index.php/profile/edit/'.$user['user_id']; ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Education</label>
                    <input type="text" name="education" value="<?php echo set_value('education', $profile['education']); ?>" class="form-control">
                    <?php echo form_error('education'); ?>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" value="<?php echo set_value('phone_number', $profile['phone_number']); ?>" class="form-control">
                    <?php echo form_error('phone_number'); ?>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo set_value('address', $profile['address']); ?>" class="form-control">
                    <?php echo form_error('address'); ?>
                </div>
                <div class="form-group">
                    <label>Birth Date</label>
                    <input type="date" name="birth_date" value="<?php echo set_value('birth_date', $profile['birth_date']); ?>" class="form-control">
                    <?php echo form_error('birth_date'); ?>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                    <a href="<?php echo base_url().'index.php/user/index'; ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>
