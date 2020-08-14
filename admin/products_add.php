<?php
	include 'includes/session.php';
	include 'includes/slugify.php';
	require '../vendor/autoload.php';

	use Aws\S3\S3Client;
	use AWS\S3\S3Exception\S3Eception;

	$bucketName = getenv("S3_BUCKET");
$IAM_KEY = getenv("AWS_ACCESS_KEY_ID");
$IAM_SECRET = getenv("AWS_SECRET_ACCESS_KEY");
try {
    // You may need to change the region. It will say in the URL when the bucket is open
    // and on creation.
    $s3 = S3Client::factory(
        array(
            'credentials' => array(
                'key' => $IAM_KEY,
                'secret' => $IAM_SECRET
            ),
            'version' => 'latest',
            'region'  => 'us-east-2'
        )
    );
} catch (Exception $e) {
    // We use a die, so if this fails. It stops here. Typically this is a REST call so this would
    // return a json object.
    die("Error: " . $e->getMessage());
}
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
				// $file = $_FILES['photo']['tmp_name'][$i];
				$keyName = 'test_example/' . basename($_FILES["photo"]['name'][$i]);
				$image_url = 'https://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;

	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["photo"]['tmp_name'][$i];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	}

	echo done;
				

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