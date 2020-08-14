<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/popup.php'; ?>
<style>
.cards {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
	margin: 5px 10px;
	float: left; 
	background-color: white;
	width: 167px;
  
}

.cards:hover {
  box-shadow: 0 12px 24px 0 rgba(0,0,0,0.2);
}

.containers {
  padding: 2px 10px;
  text-align: center;
  margin: 0 0;
  

}
.mini{
	color: black;
}

</style>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
	        		?>
	        		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		                <ol class="carousel-indicators">
		                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
						  <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="5" class=""></li>

		                </ol>
		                <div class="carousel-inner">
		                  <div class="item active">
		                    <img src="images/Independence_day.jpg" alt="First slide">
		                  </div>
						  <div class="item">
		                    <img src="images/Live-demo.jpg" alt="Fourth slide">
		                  </div>
		                  <div class="item">
		                    <img src="images/Juturu_electronics.jpg" alt="Second slide">
		                  </div>
						  <div class="item">
		                    <img src="images/Kdp_branch.jpg" alt="Third slide">
		                  </div>
						  <div class="item">
		                    <img src="images/Pdtr-branches.jpg" alt="Fifth slide">
		                  </div>
		                </div>
		                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		                  <span class="fa fa-angle-left"></span>
		                </a>
		                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		                  <span class="fa fa-angle-right"></span>
		                </a>
		            </div>
					<h2>category</h2>
					<div class="row">
					<?php  
					
					try{
						$stmt = $conn->prepare("SELECT * FROM category");
						$stmt->execute();
						foreach($stmt as $row){
						  echo "
							<div class=\"cards\" col-sm-4>
							<div class=\"containers\">
								<h4>
								<a class=\"mini\" href='category.php?category=".$row['cat_slug']."'>".strtoupper($row['name'])."</a>
								</h4> 
							</div>
							</div>
						  ";                  
						}
					  }
					  catch(PDOException $e){
						echo "There is some problem in connection: " . $e->getMessage();
					  }
					
					?>
					</div>
		            <!-- <h2>Monthly Top Sellers</h2> -->
		       		<?php
		       			// $month = date('m');
		       			// $conn = $pdo->open();

		       			// try{
		       			//  	$inc = 3;	
						//     $stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
						//     $stmt->execute();
						//     foreach ($stmt as $row) {
						//     	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						//     	$inc = ($inc == 3) ? 1 : $inc + 1;
	       				// 		if($inc == 1) echo "<div class='row'>";
	       				// 		echo "
	       				// 			<div class='col-sm-4'>
	       				// 				<div class='box box-solid'>
		       			// 					<div class='box-body prod-body'>
		       			// 						<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       			// 						<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       			// 					</div>
		       			// 					<div class='box-footer'>
		       			// 						<b>&#36; ".number_format($row['price'], 2)."</b>
		       			// 					</div>
	       				// 				</div>
	       				// 			</div>
	       				// 		";
	       				// 		if($inc == 3) echo "</div>";
						//     }
						//     if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
						// 	if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						// }
						// catch(PDOException $e){
						// 	echo "There is some problem in connection: " . $e->getMessage();
						// }

						// $pdo->close();

		       		?> 
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>