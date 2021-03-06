<?php 
	require_once('../config/db_connection.php');
	require_once('config/query.php');
	
	if (!isset($_SESSION['is_admin'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="keywords" content="Family Expense Manager, Family Budget" />
		<meta name="description" content="Family Expense Manager System">
		<meta name="author" content="Allarassem N Maxime">
		<!-- Favicon -->
		<link rel="shortcut icon" href="../images/logo.png">
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Income || FEM</title>
		<link rel="stylesheet" href="../css/dashboard.css">
	</head>
	<body>

		<?php include('header.php'); ?>

		<div class="main-content">
			<div class="title-left" style="font-size: 15px; color: #737373;">
				Income
			</div>

			<div class="title-right" id="myBtn">
				<div class="add">
					<a style="font-size: 15px;">Add Income</a>
				</div>
			</div>
			
			



			<div>
				<?php include('../errors.php'); ?><br>
			</div>
			<div>
				<?php include('../success.php'); ?><br>
			</div>

			
			<div style="overflow-x:auto;">
				<table style="color: #737373; font-size: 14px;">
					
					<?php 
						$total_amount = 0;
						$remaining    = 0;
						$query   = "SELECT * FROM Income ORDER BY created_at DESC";
						$results = mysqli_query($con, $query);
						if (mysqli_num_rows($results) > 0) {
							?>
								<tr style="height: 65px; font-size: 15px;">
									<th style="color: #737373;">User</th>
									<th style="color: #737373;">Source</th>
									<th style="color: #737373;">Income</th>
									<th style="color: #737373;">Remaing</th>
									<th style="color: #737373;">Date</th>
									<th style="color: #737373;">Action</th>
								</tr>
							<?php
							while($row = $results->fetch_assoc()) {
								$total_amount += $row['amount'];
								$remaining    += $row['remaining_amount'];
								// GET USER
								$user_id = $row['user_id'];
								$query   = "SELECT * FROM User WHERE user_id = '$user_id'";
								$result2 = mysqli_query($con, $query);
								if (mysqli_num_rows($result2) == 1) {
									$user_data = $result2->fetch_assoc();		
								}
								// GET SOURCE
								$source_id = $row['source_id'];
								$query   = "SELECT * FROM Source WHERE source_id = '$source_id'";
								$result3 = mysqli_query($con, $query);
								if (mysqli_num_rows($result3) == 1) {
									$source_data = $result3->fetch_assoc();		
								}
								?>
									<tr>
										<td><?php echo $user_data['user_email'] ?></td>
										<td><?php echo $source_data['name'] ?></td>
										<td><?php echo number_format($row['amount'], 2) ?></td>
										<td><?php echo number_format($row['remaining_amount'], 2) ?></td>
										<td><?php echo date('M Y',strtotime($row['created_at'])) ?></td>
										<td> 
											<!-- DELETE -->
											<form action="" method="POST" style="margin-left:-40px;">
												<input hidden name="income_id" value="<?php echo $row['income_id'] ?>"></input>
												<button name="delete-admin-income">
													<img src="../images/icons/delete.svg" style="width: 15px;">
												</button>&nbsp;&nbsp;&nbsp;
											</form>
											<!-- UPDATE -->
											<?php
												?>
													<div style="margin-left:30px; margin-top:-25px">
														<button>
															<a href="income-update.php?id1=<?php echo $row['user_id'] ?>&id2=<?php echo $row['income_id'] ?>&id3=<?php echo $source_data['source_id']; ?>&amount=<?php echo $row['amount']; ?>">
															<img src="../images/icons/edit.svg" style="width: 15px;">
															</a>
														</button>
													</div>
												<?php
											
											?>
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

			  
			<?php 
			  	if (mysqli_num_rows($results) > 0) {
					  ?>
						<div class='table-bottom-space'></div>
						<div class='table-total'>
							<button class='button-error-total'>Remaining: Ksh <?php echo number_format($remaining, 2); ?></button>
						</div>
					<?php
				}
			?>
			<?php 
				if (mysqli_num_rows($results) > 0) {
					?>
						<div class="table-total">
							<button class="button-primary-total">Income: Ksh <?php echo number_format($total_amount, 2); ?></button>
						</div>
					<?php
				}
			?>
		</div>



		<!-- The Modal -->
		<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<p style="text-align: center; font-size: 15px; color:#737373">Add Income</p>
				<form name="incomeForm" method="POST" onsubmit="return incomeValidation()">
					<div>
						<?php include('../errors.php'); ?><br>
					</div>

					<div>
						<select id="user" name="user"  style="font-size: 14px; color: #737373;  padding: 10px;">
							<option value="">Select User</option>
							<?php 
								$query_users   = "SELECT * FROM User ORDER BY created_at DESC";
								$user_result = mysqli_query($con, $query_users);

								if (mysqli_num_rows($user_result) > 0) {
									while($row = mysqli_fetch_assoc($user_result)) {
										echo '<option value="' . $row['user_id'] . '">' . $row['user_email'] . '</option>';
									}
								} else {
									// echo "0 results";
								}
							?>
						</select>
					</div><br><br>


					<div>
						<select id="source" name="source"  style="font-size: 14px; color: #737373;  padding: 10px;">
							<option value="">Select Source</option>
							<?php 
								$query_source   = "SELECT * FROM Source ORDER BY created_at DESC";
								$source_result = mysqli_query($con, $query_source);

								if (mysqli_num_rows($source_result) > 0) {
									while($row = mysqli_fetch_assoc($source_result)) {
										echo '<option value="' . $row['source_id'] . '">' . $row['name'] . '</option>';
									}
								} else {
									// echo "0 results";
								}
							?>
						</select>
					</div><br><br>

					<div>
						<input  style="font-size: 14px; color: #737373; padding: 10px;" type="text" name="amount" placeholder="Income Amount">
					</div><br><br>

					<div>
						<input class="button-primary" name="add-admin-income" type="submit" value="Add Income">
					</div>
				</form>  
				<div class="table-bottom-space"></div>
			</div>
		</div>






		<br><br><br><br><br>
		<?php include_once("../footer.php"); ?>



		
		
        <!-- JAVASCRIPT -->
		<script src="js/validation.js"></script>
		<script src="../js/modal.js"></script>
	</body>
</html>