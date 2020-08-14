<?php include 'includes/session.php'; ?>
<?php
	$conn = $pdo->open();

	$slug = $_GET['product'];

	try{
		 		
	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
	    $stmt->execute(['slug' => $slug]);
		$product = $stmt->fetch();
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	} 	
	// $stmt1 = $conn->prepare("SELECT *, products.id AS prodid FROM products RIGHT JOIN product_images on product_images.product_id=products.id WHERE product_id = :id");
	$stmt1 = $conn->prepare("SELECT image_name FROM product_images where product_id=:id LIMIT 6");
	$stmt1->execute(['id'=>$product['prodid']]);
	$image = $stmt1->fetch();
	//page view
	$now = date('Y-m-d');
	if($product['date_view'] == $now){
		$stmt = $conn->prepare("UPDATE products SET counter=counter+1 WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid']]);
	}
	else{
		$stmt = $conn->prepare("UPDATE products SET counter=1, date_view=:now WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid'], 'now'=>$now]);
	}

?>
<?php include 'includes/header.php'; ?>
<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.min.js"></script>
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.6/sweetalert2.css">
 <script   src="https://code.jquery.com/jquery-1.12.3.min.js"   integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="   crossorigin="anonymous"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body class="hold-transition skin-blue layout-top-nav">
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
		            <div class="row">
		            	<div class="col-sm-6">
						<?php foreach($image as $i){
							if(!empty($i)){?>
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
						<?php
						$count = count($image);
						for($in = 0; $in<$count; $in++){?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $in?>" class="active"></li>

							<?php
						}
						?>
						</ol>
						<div class="carousel-inner">
						<?php 
						foreach($image as $im){
							$photo = 'images/'.$im;?>
							<div class=\"item\">
								<img src="<?php echo $photo ?>" alt="<?php echo $im ?>" style="width:100%;">

							</div>
						<?php } ?>
						</div>
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
						</div>	
							<?php
						}else{?>
							<img src="<?php echo 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="large-<?php echo $i['image_name']; ?>">
							<?php

							}

						} ?>
		            		
		            		<br><br>
		            		<form class="form-inline" id="productDemoForm">
		            			<div class="form-group">
			            			<div class="input-group col-sm-5">
			            				
			            				<!-- <span class="input-group-btn">
			            					<button type="button" id="minus" class="btn btn-default btn-flat btn-lg"><i class="fa fa-minus"></i></button>
			            				</span>
							          	<input type="text" name="quantity" id="quantity" class="form-control input-lg" value="1">
							            <span class="input-group-btn">
							                <button type="button" id="add" class="btn btn-default btn-flat btn-lg"><i class="fa fa-plus"></i>
							                </button>
							            </span> -->
							            <input type="hidden" value="<?php echo $product['prodid']; ?>" name="id">
									</div>
									<button type="submit" class="btn btn-primary btn-lg btn-flat"><i class="fa fa-file-video-o"></i> View Demo</button>
<br>
									<div>
										<p style="font-weight: bold;">For better price, Please contact us</p>
									</div>
								</div>
		            		</form>
		            	</div>
		            	<div class="col-sm-6">
		            		<h1 class="page-header"><?php echo $product['prodname']; ?></h1>
		            		<h3><b>&#8377; <?php echo number_format($product['price'], 2); ?></b></h3>
		            		<p><b>Category:</b> <a href="category.php?category=<?php echo $product['cat_slug']; ?>"><?php echo $product['catname']; ?></a></p>
		            		<p><b>Description:</b></p>
		            		<p><?php echo $product['description']; ?></p>
		            	</div>
		            </div>
					<br>
					<!-- modal open -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
      
        <iframe id="iframeYoutube" width="560" height="315"  src="https://www.youtube.com/embed/e80BbX05D7Y" frameborder="0" allowfullscreen></iframe> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
					<!-- modal close -->
				    <!-- <div class="fb-comments" data-href="http://localhost/ecommerce/product.php?product=<?php echo $slug; ?>" data-numposts="10" width="100%"></div>  -->
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
	$('#add').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		quantity++;
		$('#quantity').val(quantity);
	});
	$('#minus').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		if(quantity > 1){
			quantity--;
		}
		$('#quantity').val(quantity);
	});

});

$('#productDemoForm').submit(function(e){
  	e.preventDefault();
	var product = $(this).serialize();
	c = document.cookie.split('; ');
        cookies = {};

        for(i=c.length-1; i>=0; i--){
           C = c[i].split('=');
           cookies[C[0]] = C[1];
        }
	email_cookie = cookies["email"];
	if (email_cookie == null) {
		$(document).ready(function(){
 swal({
 title: 'subscribe for out updates',
 input: 'email',
 showCancelButton: true,
 confirmButtonText: 'Submit',
 showLoaderOnConfirm: true,
 preConfirm: function (email) {
 return new Promise(function (resolve, reject) {
 setTimeout(function() {
 $.ajax({
 type: 'post',
 url: 'includes/check_mail.php',
 data: {email:email},
 success: function(result){
 if(result >0){
 reject('This email is already taken.')
 }
 else{
 $.ajax({
 type: 'post',
 url: 'includes/subscribe.php',
 data: {email:email},
 success: function(data){
 resolve()
 }
 });
 
 }
 }
 });
 
 }, 1000)
 })
 },
 allowOutsideClick: true
 }).then(function (email) {
 swal({
 type: 'success',
 title: 'Ajax request finished!',
 html: 'Submitted email: ' + email
 })
 })
 });
 

	} else {
		console.log("email exists");
		var product = $(this).serialize();
		videodisplay(e, product);

	}
	
  });
  function videodisplay(e, p){
	$("#myModal").on("hidden.bs.modal",function(){
    $("#iframeYoutube").attr("src","#");
  })
	  e.preventDefault();
	  pr = p.split("=");
		$.ajax({
  		type: 'POST',
  		url: 'includes/demo_url.php',
  		data: {id:pr[1]},
  		success: function(response){
			  console.log(response);
			  console.log("works here!!")
			  changeVideo(response);
  		 }
  	});
  }

  function changeVideo(vId){
  var iframe=document.getElementById("iframeYoutube");
  iframe.src = vId;

  $("#myModal").modal("show");
}
</script>
</body>
</html>