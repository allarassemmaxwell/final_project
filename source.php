<?php 
	require_once('config/db_connection.php');
	
	if (!isset($_SESSION['user_email'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
?>



<!DOCTYPE html>
<html>
	<head>
		<meta name="keywords" content="Family Expense Manager, Family Budget" />
		<meta name="description" content="Family Expense Manager System">
		<meta name="author" content="Allarassem N Maxime">
		<!-- Favicon -->
		<link rel="shortcut icon" href="images/logo.png">
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Source || FEM</title>
		<link rel="stylesheet" href="css/dashboard.css">
	</head>
	<body>

		<?php include('header.php'); ?>

		<div class="main-content">
			<div class="title-left" style="font-size: 15px; color: #737373;">
				Source
			</div>

			<div class="title-right" id="myBtn">
				<div class="add">
					<a style="font-size: 15px;">Add Source</a>
				</div>
			</div>
			

			<div>
				<?php include('errors.php'); ?><br>
			</div>
			<div>
				<?php include('success.php'); ?><br>
			</div>



			<div style="overflow-x:auto;">
				<table>
					<?php 
						$user_id = $_SESSION['user_id'];
						$query   = "SELECT * FROM Source WHERE user_id='$user_id' ORDER BY created_at DESC";
						$results = mysqli_query($con, $query);
						if (mysqli_num_rows($results) > 0) {
							?>
								<tr style="height: 65px; font-size: 15px;">
									<th style="color: #737373;">Name</th>
									<th style="color: #737373;">Date</th>
									<th style="color: #737373;">Action</th>
								</tr>
							<?php
							while($row = $results->fetch_assoc()) {
								?>
									<tr>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo date('M d Y',strtotime($row['created_at'])) ?></td>
										<td> 
											<!-- DELETE -->
											<form action="" method="POST" style="margin-left:-40px;">
												<input hidden name="source_id" value="<?php echo $row['source_id'] ?>"></input>
												<button name="delete-source" style="cursor: pointer;">
													<img src="images/icons/delete.svg" style="width: 15px;">
												</button>&nbsp;&nbsp;&nbsp;
											</form>
											<!-- UPDATE -->
											<div style="margin-left:30px; margin-top:-25px; color:red;">
												<button>
													<a href="source-update.php?id1=<?php echo $_SESSION['user_id'] ?>&id2=<?php echo $row['source_id'] ?>&id3=<?php echo $row['name'];?>">
														<img src="images/icons/edit.svg" style="width: 15px;" alt="">
													</a>
												</button>
											</div>
										</td>
									</tr>
								<?php 
							}
						}else {
							?>
								<div style="font-size: 15px; color: #737373; margin-top: 50px; text-align: center;">No data</div>
							<?php
						}
					?>
				</table>
			</div>
			
			<!-- The Modal -->
			<div id="myModal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<p style="text-align: center; font-size:15px; color: #737373">Source of the income</p>
					<form name="sourceForm" method="POST" onsubmit="return sourceValidation()">
						<div>
							<?php include('errors.php'); ?><br>
						</div>

						<div>
							<input  style="font-size: 14px; color: #737373;padding-left: 10px; padding-right: 10px;" type="text" name="name" id="name" placeholder="Name">
						</div><br><br>
						
						<div>
							<input class="button-primary" name="add-source" type="submit" value="Add Income Source">
						</div>
					</form>  
					<div class="table-bottom-space"></div>
				</div>
			</div>
		
			<div class="table-bottom-space"></div>
		</div>
		


		<br><br><br>
		<?php include_once("footer.php"); ?>
		


		
		
        <!-- JAVASCRIPT -->
		<script src="js/modal.js"></script>
		<script src="js/validation.js"></script>
	</body>
</html>