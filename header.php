<?php 
	session_start();
	include 'checkSession.php';
	include 'fetcher.php';	
	include 'calculations.php';
	?>
<?php include 'head.php'; ?>

<script>
	$(document).ready(function(){

	    $("#submit").click(function(){
	    	var id = $('#itemID').val();
	    	if(id) { window.location.href = "index.php?id="+id; }
	    	else { window.location.href = "index.php"; }
		});
/*
		$(".userBlock").click(function(){
		 	$(".userBlockToggled").toggle();
		});

		$(".burgerBlock").click(function(){
		 	$(".glyphicon-menu-hamburger").toggleClass("rotate");
		 	$(".sideMenu").toggleClass("slideMenu");
		});
		$(".mainWrapper").click(function(){
		 	$(".sideMenu").removeClass("slideMenu");
		 	$(".glyphicon-menu-hamburger").removeClass("rotate");
		 	$(".userBlockToggled").hide();
		});*/

		$(".userBlock").click(function(){
		 	$(".userMenu").fadeToggle("fast","linear");
		});

		$(".burgerBlock").click(function(){
		 	$(".burgerIco").toggleClass("glyphicon-menu-hamburger").toggleClass("glyphicon-plus");
		 	$(".sideMenu").toggleClass("slideMenu");
		});
		$(".mainWrapper").click(function(){
		 	$(".sideMenu").removeClass("slideMenu");
		 	$(".burgerIco").removeClass("glyphicon-plus").addClass("glyphicon-menu-hamburger");
		 	$(".userBlockToggled").hide();
		});


	});

	$(window).resize(function() {
		var w = $(window).width();
		var h = $(window).height();
		$("#size").html("Size:"+w+"x"+h);
	});

	

</script>
<body>
<div class="container-fluid topMenu">
	<div class="row">
		<div class="col-lg-12 upperMenu">
			<div class="burgerBlock">
				<span class="burgerIco glyphicon glyphicon-menu-hamburger"></span>
			</div>
			<div class="logoBlock">
				Mikflix
			</div>
			

			<div class="userBlock"> 
				<img src="img/user.jpg" class="userImgTopMenu" />
			</div>
			
			<span class="glyphicon glyphicon-play userMenu displayNone"></span>
			<div class="userBlockContent userMenu displayNone">
				<div class="listBlock">
					<ul>
						<li>Username: <?php echo $_SESSION['user']; ?></li>
						<li>Email: <?php echo $_SESSION['email']; ?></li>
						<li>Created:<?php echo $_SESSION['created']; ?></li>
					</ul>
				</div>
				<div class="bottomBlock">
					<a href="logout.php" class="logOut">Logout<span class="glyphicon glyphicon-log-out"></span></a>
				</div> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 subMenu">
			<?php 
				$arr = $_SESSION['topNav'];
				foreach ($arr as $v) {
				    echo "<a href=".$v['target'].">".$v['name']."</a>";
				}
			?>
		</div>
	</div>
</div>

<div class="sideMenu">
	<?php
	    echo "<h3> PHP List All Session Variables</h3>";
	    foreach ($_SESSION as $key=>$val)
	    echo $key." ".$val."<br/>";
	?>
</div>
<div class="container-fluid mainWrapper">




