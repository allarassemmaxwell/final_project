<?php 
  	session_start(); 

	if (!isset($_SESSION['user_email'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Dashboard || FEM</title>
		<link rel="stylesheet" href="css/dashboard.css">

        <!-- IMPORT FONT AWSOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		
		<?php include('header.php'); ?>

		<div class="main-content">
			<div class="title-left">
				Dashboard
			</div>

			<div class="title-right">
				<div class="add">
					<i class="fa fa-plus"></i> 
					<a href="expense-add.php">Add expense</a>
				</div>
			</div>
			
			<div style="margin-left:20px; background-color: red;">
				<?php if (isset($_SESSION['success'])) : ?>
					<div class="error success" >
						<h3>
							<?php 
								echo $_SESSION['success']; 
								unset($_SESSION['success']);
							?>
						</h3>
					</div>
				<?php endif ?>
			</div>
			


			<div class="table-top-space"></div>
			<table>
				<tr style="height: 65px; font-size: 18px;">
					<th>Category</th>
					<th>Product/Service</th>
					<th>Price</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
				<tr>
					<td>Alfreds Futterkiste</td>
					<td>Maria Anders</td>
					<td>ksh 150</td>
					<td>20-03-2020</td>
				  	<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
				<tr>
					<td>Centro comercial Moctezuma</td>
					<td>Francisco Chang</td>
					<td>ksh 200</td>
					<td>20-03-2020</td>
					<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
				<tr>
					<td>Ernst Handel</td>
					<td>Roland Mendel</td>
					<td>ksh 100</td>
					<td>20-03-2020</td>
					<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
				<tr>
					<td>Island Trading</td>
					<td>Helen Bennett</td>
					<td>ksh 250</td>
					<td>20-03-2020</td>
					<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
				<tr>
					<td>Laughing Bacchus Winecellars</td>
					<td>Yoshi Tannamuri</td>
					<td>ksh 350</td>
					<td>20-03-2020</td>
					<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
				<tr>
					<td>Magazzini Alimentari Riuniti</td>
					<td>Giovanni Rovelli</td>
					<td>ksh 300</td>
					<td>20-03-2020</td>
					<td>
						<i class="fa fa-trash-o icon-delete" title="Delete"></i>&nbsp;&nbsp;&nbsp;
						<i class="fa fa-pencil icon-edit" title="Edit"></i>
					</td>
				</tr>
			  </table>

			  <div class="table-bottom-space"></div>
			  <div class="table-total">
				<button class="button-error-total">Total: ksh 5.500</button>
			  </div>
		</div>



		

		<?php include_once("footer.php"); ?>
		

		
        <!-- JAVASCRIPT -->
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script src="js/dashboard.js"></script>
	</body>
</html>