<!DOCTYPE html>
<html>
<head>
    <title>Crud Application - View Users</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>">
</head>
<body>
<?php $this->load->view('navbar'); ?>

<div class="container" style="padding-top: 10px;">
    <div class="row">
        <div class="col-md-12">
            <?php 
            $success = $this->session->userdata('success');
            if ($success != "") {
                echo '<div class="alert alert-success">' . $success . '</div>';
            } 
            $failure = $this->session->userdata('failure');
            if ($failure != "") {
                echo '<div class="alert alert-danger">' . $failure . '</div>';
            } 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-6"><h3>View Users</h3></div>
                <div class="col-6 text-right">
                    <a href="<?php echo base_url().'index.php/user/create'; ?>" class="btn btn-primary">Create</a>
                </div>
            </div>
            <hr>
        </div>
    </div>  
    
    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="60">Edit</th>
                    <th width="100">Delete</th>
                    <th width="120">Profile</th> <!-- New Column -->
                </tr>

                <?php if (!empty($users)) { foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="<?php echo base_url().'index.php/user/edit/'.$user['user_id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                        <a href="<?php echo base_url().'index.php/user/delete/'.$user['user_id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                    <td>
                        <!-- Link to view or create a profile -->
                        <a href="<?php echo base_url().'index.php/profile/'. ($user['profile_exists'] ? 'view/' : 'create/') . $user['user_id']; ?>" class="btn btn-info">
                            <?php 
                            // Check if profile exists to decide the button label (View or Create)
                            echo isset($user['profile_exists']) && $user['profile_exists'] ? 'View Profile' : 'Create Profile';
                            ?>
                        </a>
                    </td>
                </tr>
                <?php } } else { ?>
                <tr>
                    <td colspan="6">Records not found</td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>
