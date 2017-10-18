<?php include 'header.php'; ?>

<div class="col-md-6">

		<div class="well">
			<h1>Top navigation administration</h1>
			<form action="controller.php" method="post">
				<input type="text" placeholder="Name" name="authKey" id="authKey" value="addTopNav" hidden>
				<input type="text" placeholder="Name" name="name" id="name" class="uploadTitle">
				<input type="text" placeholder="Target" name="target" id="target"  class="uploadTitle">
				<input type="text" placeholder="Rank" name="rank" id="rank"   class="uploadTitle">
				<input type="submit">
			</form>
		</div>


		<div class="well">
			<h1>Current top navigation</h1>
			<ul>
				<?php 
	
				$arr = $_SESSION['topNav'];
				foreach ($arr as $v) {
				    echo "<li> <h1>#".$v['rank']." ".$v['name']."</h1> (".$v['target'].")</li>";
				    echo '<form action="controller.php" method="post">
							<input type="text" name="authKey" id="authKey" hidden value="delTopNav">
					        <input type="text" name="id" id="id" hidden value='.$v["id"].'>
					        <input type="text" name="user" hidden value='.$currentUser.'>
					        <input type="submit" name="submit" value="Delete">
					    </form>';
				}

				?>
				
			</ul>
		</div>

</div>

<div class="col-md-6">

	<div class="well">
		<h1>User data</h1>
		<?php
		$v = $_SESSION['userData'];
		echo "Username =  ".$v['user'];
		echo "<br>Account Created =  ".$v['created'];
		echo "<br>Email adress =  ".$v['email'];		
		?>
	</div>
	<div class="well">
		<h1>Global settings</h1>
		<?php
		$arr = $_SESSION['globalSettings'];
			foreach ($arr as $v) {
				echo $v['title']." = ".$v['value']."<br>";
			}
		?>
	</div>
	<div class="well">
		<h1>Restriction Levels</h1>
		<?php
		$arr = $_SESSION['restrictionLevels'];
			foreach ($arr as $v) {
				echo "#".$v['rank']." ".$v['title']. " - (".$v['description'].")<br>";
			}
		?>
	</div>
	<div class="well">
		<h1>All users</h1>
		<table class="table table-striped">
			<tr>
				<th>Username</th>
				<th>Email</th>
				<th>Created</th>
			</tr>
				<?php
					$rs = queryServer("Select * from logindb order by id asc");
					while($row = mysqli_fetch_assoc($rs)) {
						echo "<tr>";
						echo "<td>".$row['user']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['created']."</td>";
						echo "</tr>";
					}
				?>
		</table>
	</div>
</div>
