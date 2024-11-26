<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>">
</head>
<body>
<?php $this->load->view('navbar'); ?>

<div class="container" style="padding-top: 10px;">
    <h3>Profile Details</h3>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td><?php echo $user['name']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $user['email']; ?></td>
        </tr>
        <tr>
            <th>Education</th>
            <td><?php echo $profile['education']; ?></td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td><?php echo $profile['phone_number']; ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?php echo $profile['address']; ?></td>
        </tr>
        <tr>
            <th>Birth Date</th>
            <td><?php echo date('Y-m-d', strtotime($profile['birth_date'])); ?></td>
        </tr>
    </table>
    <a href="<?php echo base_url().'index.php/profile/edit/'.$user['user_id']; ?>" class="btn btn-primary">Edit Profile</a>
    <a href="<?php echo base_url().'index.php/user/index'; ?>" class="btn btn-secondary">Back to Users</a>
</div>
</body>
</html>
