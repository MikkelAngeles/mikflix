<html>
<head>
<?php include 'head.php'; ?>
<link rel="stylesheet" type="text/css" href="css/login.css" />
<script>
	$(document).ready(function(){
		$(".switch").click(function() {
			$(".userLogin").toggle();
			$(".createUser").toggle();
		})
	});
</script>
</head>
<body>
	<div class="container login">
	<?php 
	if(isset($_GET['login_attempt'])) $loginattempt = $_GET['login_attempt'];
	else $loginattempt = false;
	if($loginattempt) { echo "Login failed"; }
	?>
		<div class="userLogin">
			<form method="post" action="auth.php">
			  <div class="input-group">
			    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			    <input id="user" type="text" class="form-control" name="user" placeholder="Username" requiured>
			  </div>
			  <div class="input-group">
			    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			    <input id="password" type="password" class="form-control" name="password" placeholder="Password" requiured>
			  </div>
			  <div class="col-lg-2">
				  <div class="input-group">
				  	<input id="submit" type="submit" value="Login" class="btn btn-success">
				  </div>
			  </div>
		  	</form>
			<div class="col-lg-3">
				<button class="switch btn btn-info">Create user</button>
			</div>
		</div>

		<div class="createUser displayNone">
			<form method="post" action="createUser.php">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="user" type="text" class="form-control" name="user" placeholder="Username" requiured>
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="email" type="text" class="form-control" name="email" placeholder="Email" requiured>
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="password" placeholder="Password" requiured> 
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password2" type="password" class="form-control" name="password2" placeholder="Password" requiured> 
				</div>
				<div class="col-lg-3">
				  <div class="input-group">
				  	<input type="submit" id="submit" value="Create user" class="btn btn-success">
				  </div>
				  </form>
				</div>
			<div class="col-lg-2">
			<button class="switch btn btn-info">Back</button>
			</div>

		</div>
		
	</div>
	</div>
	<div class="title">
		<h1>Charlotte & Mikkels boligkøb<h1>
	</div>
</body>
</html>