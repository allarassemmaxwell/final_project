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
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Income Add || FEM</title>
		<link rel="stylesheet" href="css/dashboard.css">

        <!-- IMPORT FONT AWSOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		
		<?php include('header.php'); ?>

		<div class="main-content">
            
                <div class="title-left">
                    <a href="income.php" style="text-decoration: none; color: #333;">Income</a>
                    /Add
                </div>


            <div class="table-top-space"></div>
            

			


            <form class="add-income-form" method="POST">
				<div>
					<?php include('errors.php'); ?><br>
				</div>
				
                <div>
					<select id="source" name="source">
						<option value="">--- Select Source ---</option>
                        <?php 
                            $user_id   = $_GET['id1'];
                            $income_id = $_GET['id2'];
                            $source_id = $_GET['id3'];
                            $amount    = $_GET['amount'];

							$query   = "SELECT * FROM Source WHERE user_id = '$user_id' ORDER BY created_at DESC";
							$results = mysqli_query($con, $query);

							if (mysqli_num_rows($results) > 0) {
								while($row = mysqli_fetch_assoc($results)) {
                                    if($row['source_id'] == $source_id) {
										echo '<option value="' . $row['source_id'] . '" selected>' . $row['name'] . '</option>';
									}
									echo '<option value="' . $row['source_id'] . '">' . $row['name'] . '</option>';
								}
							} else {
								// echo "0 results";
							}
						?>
					</select>
				</div><br><br>

                <div>
					<input type="text" value="<?php echo $amount; ?>" name="amount" placeholder="Amount">
                    <input type="text" hidden name="income_id" value="<?php echo $income_id; ?>">
					<input type="text" hidden name="user_id" value="<?php echo $user_id; ?>">
				</div><br><br>
				
                <div>
                    <input class="button-primary" name="update-income" type="submit" value="Create">
                </div>
            </form>  


		</div>



		<?php include_once("footer.php"); ?>
		
		
		
        <!-- JAVASCRIPT -->
		<script
			src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			crossorigin="anonymous">
		</script>   
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
		<script src="js/dashboard.js"></script>
	</body>
</html>