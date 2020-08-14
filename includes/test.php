<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Example of Embedding YouTube Video inside Bootstrap Modal</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    .bs-example{
    	margin: 20px;
    }
    .modal-content iframe{
        margin: 0 auto;
        display: block;
    }
</style>
<script>
$(document).ready(function(){
    /* Get iframe src attribute value i.e. YouTube video url
    and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
});
</script>
</head>
<body>
<div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
    <a href="#myModal" class="btn btn-lg btn-primary" data-toggle="modal">Launch Demo Modal</a>
    
    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">YouTube Video</h4>
                </div>
                <div class="modal-body">
                    <iframe id="cartoonVideo" width="560" height="315" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>     
</body>
</html>


<?php foreach($image as $i){
							if(!empty($i)){?>
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
						<?php
						$count = count($image);
						for($in = 1; $in<=$count; $in++){?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $in?>" class="active"></li>

							<?php
						}
						?>
						</ol>
						<div class="carousel-inner">
						<?php 
						foreach($image as $im){
							$photo = $im;?>
							<div class="item">
							<span>hello</span>
								<img src="<?php echo $photo ?>" alt="<?php echo $im ?>" style="width:100%;"  data-magnify-src="images/large-<?php echo $im; ?>">

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