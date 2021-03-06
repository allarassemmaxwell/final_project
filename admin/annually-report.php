<?php 
	require_once('../config/db_connection.php');
	
	if (!isset($_SESSION['user_id'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}
	
	$user_id = $_SESSION['user_id'];
	$query   = "SELECT * FROM User WHERE user_id = '$user_id'";
	$results = mysqli_query($con, $query);
	if (mysqli_num_rows($results) == 1) {
		$profile_data = $results->fetch_assoc();		
	}

	$jsonArray = array();
	$the_year   = date("Y");
	if (isset($_POST['filterByDate'])) {
		$projected_date = mysqli_real_escape_string($con, $_POST['projected_date']);
		$the_year = $projected_date;
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
		<title>Annually Report || FEM</title>
		<link rel="stylesheet" href="../css/dashboard.css">
	</head>
	<body>


		<?php include('header.php'); ?>

		<div class="main-content">
			<div class="title-left" style="font-size: 15px; color: #737373;">
				Annually Report
			</div>

			


			<div style="overflow-x:auto;" id="tblCustomers" cellspacing="0" cellpadding="0">
				<div class="report-title">
				<div style="font-size:18px; text-align:center;">Annual Report</div>
					<div class="report-filter" onclick="shoFilterByAnnual()" style="float: right; margin-top: -35px; font-size: 15px;">
						<button style=" color: #00C2FF; height: 30px;  cursor: pointer; border: 1px solid #00C2FF;">Filter by Year</button>
					</div>
					<form name="filterByForm" method="POST" onsubmit="return filterByValidation()">
						<div id="filter">
							<input type="number" placeholder="YYYY" min="2017" max="2020" style="font-size: 14px; color: #737373; padding: 25px; height: 15px;" value="<?php echo $projected_date; ?>" name="projected_date" id="projected_date">
							<input type="submit" name="filterByDate" style="color: #00C2FF;" value="Filter">
						</div>
					</form>
					<div>Full Name: <?php echo $profile_data['first_name']; ?>&nbsp;&nbsp; <?php echo $profile_data['last_name']; ?></div>
					<div>Email: <?php echo $profile_data['user_email']; ?></div>
					<div>Date: <?php echo  date("M"); ?>/<?php echo  date("d"); ?>/<?php echo  date("Y"); ?></div>
				</div>

				<div id="chartContainer" style="height: 350px; width: 95%; margin-left: auto; margin-right: auto;"></div>

				<table style="margin-top: 15px;">
					<?php
						$total_expenditure = 0;
						$query1     = "SELECT * FROM Expense WHERE YEAR(created_at) = '$the_year' ORDER BY created_at DESC";
						$results 	= mysqli_query($con, $query1);
						if (mysqli_num_rows($results) > 0) {
							?>
								<tr style="height: 65px; font-size: 15px; color: #737373;">
									<th style="color: #737373;">Source</th>
									<th style="color: #737373;">Income</th>
									<th style="color: #737373;">Category</th>
									<th style="color: #737373;">Product/Service</th>
									<th style="color: #737373;">Price</th>
									<th style="color: #737373;">Date</th>
								</tr>
							<?php
							while($row = $results->fetch_assoc()) {
								$total_expenditure += $row['price'];
								// GET PRODUCT SERVICE NAME
								$product_service_id = $row['product_service_id'];
								$query2   = "SELECT * FROM ProductService WHERE product_service_id = '$product_service_id'";
								$result2 = mysqli_query($con, $query2);
								if (mysqli_num_rows($result2) == 1) {
									$product_service_data = $result2->fetch_assoc();		
								}

								// GET PRODUCT CATEGORY NAME
								$product_category_id = $product_service_data['product_service_category_id'];
								$query3   = "SELECT * FROM ProductServiceCategory WHERE category_id = '$product_category_id'";
								$result3 = mysqli_query($con, $query3);
								if (mysqli_num_rows($result3) == 1) {
									$product_category_data = $result3->fetch_assoc();		
								}

								// GET INCOME NAME
								$income_id = $row['income_id'];
								$income_query   = "SELECT * FROM Income WHERE income_id = '$income_id'";
								$income_result  = mysqli_query($con, $income_query);
								if (mysqli_num_rows($income_result) == 1) {
									$income_data = $income_result->fetch_assoc();		
								}

								// GET SOURCE NAME
								$source_id = $income_data['source_id'];
								$source_query   = "SELECT * FROM Source WHERE source_id = '$source_id'";
								$source_result  = mysqli_query($con, $source_query);
								if (mysqli_num_rows($source_result) == 1) {
									$source_data = $source_result->fetch_assoc();		
								}
								$jsonArrayItem = array();
								$jsonArrayItem['label'] = $product_category_data['name'];
								$jsonArrayItem['y'] = $row['price'];
								array_push($jsonArray, $jsonArrayItem);

								?>
									<tr>
										<td><?php echo $source_data['name'] ?></td>
										<td><?php echo number_format($income_data['amount'], 2) ?></td>
										<td><?php echo $product_category_data['name'] ?></td>
										<td><?php echo $product_service_data['name'] ?></td>
										<td><?php echo number_format($row['price'], 2) ?></td>
										<td><?php echo date('M d Y',strtotime($row['created_at'])) ?></td>
									</tr>
								<?php 
							}
						} else {
							?>
								<div style="font-size: 15px; color: #737373; margin-top: 50px; text-align: center;">No data</div>
							<?php
						}
					?>	
				</table>

				<div class="table-bottom-space"></div>
			<?php 
			  	if (mysqli_num_rows($results) > 0) {
					?>
						<div class="table-total">
							<button class="button-error-total">Expenses: ksh <?php echo number_format($total_expenditure, 2); ?></button>
						</div>
					<?php
				} else {
					?>
						<div class="table-total">
							<button class="button-error-total">Expenses: ksh 0</button>
						</div>
					<?php
				}
			?>

			<?php
				$total_income = 0;
				$total_income_query     = "SELECT * FROM Income WHERE YEAR(created_at) = '$the_year' ORDER BY created_at DESC";
				$total_income_result 	= mysqli_query($con, $total_income_query);
				if (mysqli_num_rows($total_income_result) > 0) {
					while($income_row = $total_income_result->fetch_assoc()) {
						$total_income += $income_row['amount'];
					}
					?>
						<div class="table-total">
							<button class="button-light-total">Income: ksh <?php echo number_format($total_income, 2); ?></button>
						</div>
					<?php
				} else {
					?>
						<div class="table-total">
							<button class="button-light-total">Income: ksh 0</button>
						</div>
					<?php
				}
			?>



			<?php
				$total_saving  = 0;
				$saving_query  = "SELECT * FROM Saving WHERE YEAR(created_at) = '$the_year'";
				$saving_result = mysqli_query($con, $saving_query);
				if (mysqli_num_rows($saving_result) > 0) {
					while($saving_row = $saving_result->fetch_assoc()) {
						$total_saving += $saving_row['amount'];
					}
					?>
						<div class="table-total">
							<button class="button-primary-total">Save: Ksh <?php echo number_format($total_saving, 2); ?></button>
						</div>
					<?php
				} else {
					?>
						<div class="table-total">
							<button class="button-primary-total">Save: Ksh 0</button>
						</div>
					<?php
				}
			?>
			</div>      
		</div>




		
		<br><br><br><br><br>
		<?php include_once("../footer.php"); ?>
		
		<style>
			#filter {
				display: none;
			}
		</style>
		<!-- SHOW AND HIDE FILTER FORM -->
		<script>
			function shoFilterByAnnual() {
				var filter = document.getElementById("filter");
				if(filter.style.display === "block") {
					filter.style.display = "none";
				} else {
					filter.style.display = "block";
				}
			}
		</script>

		
        <!-- JAVASCRIPT -->
		<script src="../js/import-jquery.js"></script>
    	<script src="js/validation.js"></script>


		<!-- CHART -->
		<script src="../js/canvas.js"></script>
		<script type="text/javascript">
			window.onload = function() {

				var dataPoints = <?php echo json_encode($jsonArray, JSON_NUMERIC_CHECK); ?>;
				console.log("=====JAVASCRIPT======");
				console.log(dataPoints);
				var labelArr = [];
				var totalArr = [];
				for (let index = 0; index < dataPoints.length; index++) {
					const element = dataPoints[index].label;
					if(labelArr.includes(element)) {
						// DO NOTHING
					} else {
						labelArr.push(element);
					}
				}


				for (let index = 0; index < labelArr.length; index++) {
					var price = [];
					const element = labelArr[index];

					console.log("=====ELEMENT======");
					console.log(element);
					for (let i = 0; i < dataPoints.length; i++) {
						const p = dataPoints[i];
						if(p.label === element) {
							price.push(p.y);
							console.log("===== P.Y ======");
							console.log(p.y);
						}
						
					}
					console.log("===== PRICE HERE ======");
					console.log(price);

					var total = price.reduce((a, b) => {
						return a+b;
					})
					console.log("===== TOTAL ======");
					console.log(total);
					totalArr.push({label:element, y:total});

				}

				console.log("===== TOTAL ARR ======");
				console.log(totalArr);

				var options = {
					title: {
						text: "Statistics"
					},
					data: [{
						type: "pie",
						startAngle: 45,
						showInLegend: "true",
						legendText: "{label}",
						indexLabel: "{label} ({y})",
						yValueFormatString:"#,##0.#"%"",
						dataPoints: totalArr
					}]
				};
				$("#chartContainer").CanvasJSChart(options);
			}
		</script>
	</body>
</html>