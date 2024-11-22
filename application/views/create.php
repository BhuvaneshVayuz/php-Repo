<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced PHP Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: cyan;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        h3 {
            text-align: center;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .message {
            font-size: 18px;
            color: purple;
        }
    </style>
</head>
<body>

<h3>bekkaar php</h3>

<form action="" method="POST">
    <label for="name">Enter your name:</label>
    <input type="text" name="name" id="name">

    <label for="age">Enter your age:</label>
    <input type="number" name="age" id="age">

    <label for="color">Favorite color:</label>
    <input type="text" name="color" id="color">

    <label for="message">Your message:</label>
    <input type="text" name="message" id="message">

    <input type="submit" value="Submit">
</form>

 php include('function.php'); 

</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
	<title>There's something inside u</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
</head>
<body>
<div class="navbar navbar-dark bg-dark">
	<div class="container">
		<a href="#" class="navbar-brand">CRUD APPLICATION</a>
	</div>
</div>
<div class="container" style="padding-top: 10px;">
	<h3>Create User</h3>
	<hr>
	<form method="post" name="createUser" action="<?php echo base_url().'index.php/user/create';?>">
	<div class="row">
		
		<div class="col-md-6">
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" value="<?php echo set_value('name');?>" class="form-control">
				<?php echo form_error('name');?>
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" value="<?php echo set_value('email');?>" class="form-control">
				<?php echo form_error('email');?>
			</div>
			<div class="form-group">
				<button class="btn btn-primary">Create</button>
				<a href="<?php echo base_url().'index.php/user/index';?>" class="btn-secondary btn">Cancel</a>
			</div>
		</div>
		
	</div>
	</form>
</div>

</body>
</html>