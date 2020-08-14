<?php
	include 'includes/session.php';
	include 'includes/slugify.php';
	require '../vendor/autoload.php';

	use Aws\S3\S3Client;
	use AWS\S3\S3Exception\S3Eception;

	include('config_s3.php');

	// $s3 = new Aws\S3\S3Client([
	// 	'version'  => '2006-03-01',
	// 	'region'   => 'us-east-1',
	// ]);
	// $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var is found in env!');
	// $bucket = 'juturu';
	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$slug = slugify($name);
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$countfiles = count($_FILES['photo']['name']);
		$prod_id = uniqid();
		echo $prod_id;
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE slug=:slug");
		$stmt->execute(['slug'=>$slug]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Product already exist';
		}
		else{
			for($i=0; $i<$countfiles; $i++){
				$filename = $_FILES['photo']['name'][$i];
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$new_filename = $slug.$i.'.'.$ext;
				// move_uploaded_file($_FILES['photo']['tmp_name'][$i], '../images/'.$new_filename);	
				$file = $_FILES['photo']['tmp_name'][$i];
				// try {
				// 	$upload = $s3->upload($bucket, $file, fopen($file, 'rb'), 'public-read');
				// 	$image_url = $upload->get('ObjectURL');
				// }
				// catch(Exception $e){
				// 	echo $e->getMessage();

				// }
				try{
					$client->putObject(array(
						'Bucket'=>$bucket,
						'Key' => $new_filename,
						'SourceFile' => $file,
						'StorageClass' => 'REDUCED_REDUNDANCY'
					));
				$message = "s3 uPLOAD sUCCESSFUL.";
				$image_url = 'https://'.$bucket.'s3.amazonaws.com/'.$new_filename;
				}catch(S3Exception $e){
					echo $e->getMessage();
				}
				

			}
			else{
				$new_filename = '';
			}
			try{
				$stmt1 = $conn->prepare("INSERT INTO product_images (product_id, image_name) VALUES (:product_id, :image_name)");
				$stmt1-> execute(['product_id'=>$prod_id, 'image_name' => $image_url]);
				$SESSION['success'] = 'Image uploaded Successfully';
			}
			catch(PDOException $e){
				$SESSION['error'] = $e->getMessage();
			}
		}

			try{
				$stmt = $conn->prepare("INSERT INTO products (id, category_id, name, description, slug, price) VALUES (:id, :category, :name, :description, :slug, :price)");
				$stmt->execute(['id' => $prod_id, 'category'=>$category, 'name'=>$name, 'description'=>$description, 'slug'=>$slug, 'price'=>$price]);
				$_SESSION['success'] = 'Product added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up product form first';
	}


	header('location: products.php');

?>