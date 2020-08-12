<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

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
				move_uploaded_file($_FILES['photo']['tmp_name'][$i], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}
			try{
				$stmt1 = $conn->prepare("INSERT INTO product_images (product_id, image_name) VALUES (:product_id, :image_name)");
				$stmt1-> execute(['product_id'=>$prod_id, 'image_name' => $new_filename]);
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