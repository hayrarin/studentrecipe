<!--
in this file we write code for connection with database.
-->
<?php
$conn = mysqli_connect("localhost","root","","recipebook");

if(!$conn)
{
	echo "Database connection failed...";
}

//////////QUERY////////////////////////
function query($query){

	global $conn;
	 $result = mysqli_query($conn, $query);
	 $rows = [];
	 while($row = mysqli_fetch_assoc($result)){///////error
		 $rows[] = $row;
	 }
	 return $rows;
	}

////////////////// ADD NEW ADMIN 
function addadmin($data){
	global $conn;

	$username = stripcslashes($data["username"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	//cek username sudh ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM  admin WHERE username = '$username'");
	
	if(mysqli_fetch_assoc($result)){
		echo "<script>
				alert('username already taken')
				</script>";

				return false;
	}
	//cek username
	if(strlen($username)> 10){
		echo "<script>
		alert('Username only 10 characters max');	
		</script>";
		return false;
	}
	//cek password
	if(strlen($password) < 5){
		echo "<script>
		alert('Password must be 5 characters minimum');	
		</script>";
		return false;
	}
	//cek confirm password
	if($password !== $password2){
		echo "<script>
				alert('Password not the same');	
		</script>";

		return false;
	}
	///////////enkripsi password//////////

	//$password = md5($password);----->> bahaya!!!! boleh cek gne google
	$password = password_hash($password, PASSWORD_DEFAULT);

	//var_dump($password);die;--------> tgk string encrpyt


	///tambah user baru ke db
	mysqli_query($conn, "INSERT INTO admin VALUES('', '$username','admin','','$password','active')");

	return mysqli_affected_rows($conn);
}

function registeruser($data) {
    global $conn;
    
    // Extract the form data
    $username = mysqli_real_escape_string($conn, trim($data['username']));
    $email = mysqli_real_escape_string($conn, trim($data['email']));
    $password = mysqli_real_escape_string($conn, trim($data['password']));
    
    // Perform necessary validation on the data
    if (empty($username) || empty($email) || empty($password)) {
        // Handle empty fields error
        return -1;
    }
    
    // Check if the username or email already exists in the database
    $query = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // Handle username or email already exists error
        return -2;
    }
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the user data into the database
    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
}

function registerdesigner($data) {
    global $conn;
    
    // Extract the form data
    $username = mysqli_real_escape_string($conn, trim($data['username']));
    $email = mysqli_real_escape_string($conn, trim($data['email']));
    $password = mysqli_real_escape_string($conn, trim($data['password']));
    
    // Perform necessary validation on the data
    if (empty($username) || empty($email) || empty($password)) {
        // Handle empty fields error
        return -1;
    }
    
    // Check if the username or email already exists in the database
    $query = "SELECT * FROM designer WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // Handle username or email already exists error
        return -2;
    }
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the designer data into the database
    $query = "INSERT INTO designer (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    $result = mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn);
}


//////////////////ADD designer//////////////////////////
function adddesigner($data){
	global $conn;

	$username = stripcslashes($data["username"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	//cek username sudh ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM  designer WHERE username = '$username'");
	
	if(mysqli_fetch_assoc($result)){
		echo "<script>
				alert('username already taken')
				</script>";

				return false;
	}
	//cek username
	if(strlen($username)> 10){
		echo "<script>
		alert('Username only 10 characters max');	
		</script>";
		return false;
	}
	//cek password
	if(strlen($password) < 5){
		echo "<script>
		alert('Password must be 5 characters minimum');	
		</script>";
		return false;
	}
	//cek confirm password
	if($password !== $password2){
		echo "<script>
				alert('Password not the same');	
		</script>";

		return false;
	}
	///////////enkripsi password//////////

	//$password = md5($password);----->> bahaya!!!! boleh cek gne google
	$password = password_hash($password, PASSWORD_DEFAULT);

	//var_dump($password);die;--------> tgk string encrpyt


	///tambah user baru ke db
	mysqli_query($conn, "INSERT INTO designer VALUES('', '$username', '$password','','','','designer','active')");

	return mysqli_affected_rows($conn);
}

//////////////////ADD user//////////////////////////
function adduser($data){
	global $conn;

	$username = stripcslashes($data["username"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	//cek username sudh ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM  user WHERE username = '$username'");
	
	if(mysqli_fetch_assoc($result)){
		echo "<script>
				alert('username already taken')
				</script>";

				return false;
	}
	//cek username
	if(strlen($username)> 10){
		echo "<script>
		alert('Username only 10 characters max');	
		</script>";
		return false;
	}
	//cek password
	if(strlen($password) < 5){
		echo "<script>
		alert('Password must be 5 characters minimum');	
		</script>";
		return false;
	}
	//cek confirm password
	if($password !== $password2){
		echo "<script>
				alert('Password not the same');	
		</script>";

		return false;
	}
	///////////enkripsi password//////////

	//$password = md5($password);----->> bahaya!!!! boleh cek gne google
	$password = password_hash($password, PASSWORD_DEFAULT);

	//var_dump($password);die;--------> tgk string encrpyt


	///tambah user baru ke db
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password','','','','user','active','','')");

	return mysqli_affected_rows($conn);
}

/////////UPDATE////////////////
function update($update){
	global $conn;

	//ambik data dri form
	$id = $update["id"];
	$name = htmlspecialchars($update["name"]);////////elak user hack gne html dlm form
	$prep_time = htmlspecialchars($update["prep_time"]);
	$cook_time = htmlspecialchars($update["cook_time"]);
	$ingredient = htmlspecialchars($update["ingredient"]);
	$steps = htmlspecialchars($update["steps"]);
	$oldpictrue = htmlspecialchars($update["oldpicture"]);
    $oldvideo = htmlspecialchars($update["oldvideo"]);
	$url = htmlspecialchars($update["video_url"]);
	
	//cek apakah user tmbh gambar atau x
	if($_FILES['picture']['error']=== 4){
		$picture = $oldpictrue;
	}else{
		$picture = upload();
	}
    
    if($_FILES['video']['error']=== 4){
		$video = $oldvideo;
	}else{
		$video = uploadvideo();
	}


	//query update data
	$query = "UPDATE recipes SET  name = '$name', prep_time = '$prep_time', cook_time = '$cook_time', ingredient = '$ingredient', picture = '$picture', steps = '$steps', video_url = '$url', videoname = '$video' WHERE id = $id ";

	if (mysqli_query($conn,$query)){
		return 1;
	}else{
		return 0;
	}

	// return mysqli_affected_rows($conn);
	
}

/////////UPDATE////////////////
function updatedesigner($designerID, $username, $name, $email, $phone, $status)
{
    global $conn;

    // Prepare the data for inserting into the database
    $designerID = mysqli_real_escape_string($conn, $designerID);
    $username = mysqli_real_escape_string($conn, $username);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);

    // Set the status as "Active"
    $status = "Active";

    // Perform the necessary update query to update the designer's information
    $query = "UPDATE designer SET username = '$username', name = '$name', email = '$email', phone = '$phone', status = '$status' WHERE designerID = $designerID";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_affected_rows($conn);
    } else {
        return false;
    }
}

/////////UPDATE////////////////
function updateuser($userID, $username, $name, $email, $phone, $status)
{
    global $conn;

    // Prepare the data for inserting into the database
    $userID = mysqli_real_escape_string($conn, $userID);
    $username = mysqli_real_escape_string($conn, $username);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);

    // Set the status as "Active"
    $status = "Active";

    // Perform the necessary update query to update the designer's information
    $query = "UPDATE user SET username = '$username', name = '$name', email = '$email', phone = '$phone', status = '$status' WHERE userID = $userID";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return mysqli_affected_rows($conn);
    } else {
        return false;
    }
}

/////////////ADD/////////////////////////////
function add($data){//////////terima value form add data
	global $conn;
	$category = $_POST['category'];
	$name = htmlspecialchars($data["name"]);////////elak user hack gne html dlm form
	$prep_time = htmlspecialchars($data["prep_time"]);
	$cook_time = htmlspecialchars($data["cook_time"]);
	$ingredient = htmlspecialchars($data["ingredient"]);
	$steps = htmlspecialchars($data["steps"]);
	$url = htmlspecialchars($data["video_url"]);

	//upload gambar
	$picture = upload();
    $video = uploadvideo();
	if( !$picture){
		return false;/////kalau gagal false query x jalan
	}
	
	//query insert data
	$query = "INSERT INTO recipes VALUES ('','$category','$picture','$name','$prep_time','$cook_time','$ingredient','$steps','$url','$video','','')";

	mysqli_query($conn,$query);

	return mysqli_affected_rows($conn);

}

/////////////UPLOAD//////////////////////////

function upload(){
	$namaFile = $_FILES['picture']['name'];//////gambar amik dari form name="gambar"
	$ukuranFile = $_FILES['picture']['size'];
	$error = $_FILES['picture']['error'];
	$tmpName = $_FILES['picture']['tmp_name'];///location gambar disimpan

	//cek apakh tidak ad gambar diupload 
	if( $error === 4){
		echo "<script>
				alert('Choose the picture')
				</script>";
		return false;
	}

	//cek apakh upload itu gambar
	$valid = ['jpg','jpeg','png'];
	$extension = explode('.', $namaFile);
	$extension = strtolower(end($extension));
	if(!in_array($extension, $valid)){
		echo"<script>
			alert('The file is not a picture!')
			</script>";

			return false;
	}

	//cek jika saiz gambar besar
	if($ukuranFile > 5000000)//////jika saiz > 1mb
	{
		echo "<script>
		alert('The maximum size is 5mb only!')
		</script>";
	return false;
	}
	//generate nama fail gambar yg unik
	$namaFileBaru = uniqid();
	$namaFileBaru.=  '.';
	$namaFileBaru.= $extension;

	//pindhkan gambar diupload ke fail images
	move_uploaded_file($tmpName, 'img/'. $namaFileBaru);/////gmabr simpan ke images folder

	return $namaFileBaru;///return nama fail
}

/////////////UPLOAD//////////////////////////

function uploadvideo(){
    $namaFile = $_FILES['video']['name'];//////gambar amik dari form name="gambar"
	$ukuranFile = $_FILES['video']['size'];
	$error = $_FILES['video']['error'];
	$tmpName = $_FILES['video']['tmp_name'];///location gambar disimpan

	//cek apakh tidak ad gambar diupload 
	if( $error === 4){
		echo "<script>
				alert('Choose the video')
				</script>";
		return false;
	}

	//cek apakh upload itu gambar
	$valid = ['mp4','avi','3gp','mov','mpeg'];
	$extension = explode('.', $namaFile);
	$extension = strtolower(end($extension));
	if(!in_array($extension, $valid)){
		echo"<script>
			alert('The file is not a video!')
			</script>";

			return false;
	}

	//cek jika saiz gambar besar
	if($ukuranFile > 50000000000000)//////jika saiz > 1mb
	{
		echo "<script>
		alert('The maximum size is 5mb only!')
		</script>";
	return false;
	}
	//generate nama fail gambar yg unik
	$namaFileBaru = uniqid();
	$namaFileBaru.=  '.';
	$namaFileBaru.= $extension;

	//pindhkan gambar diupload ke fail images
	move_uploaded_file($tmpName, 'videos/'. $namaFileBaru);/////gmabr simpan ke images folder

	return $namaFileBaru;///retur
}

////////DELETE///////////////////
function deleteuser($id){
	global $conn;

	//query delete data

	$query = "DELETE FROM user WHERE userID = $id";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deleteadmin($id){
	global $conn;

	//query delete data

	$query = "DELETE FROM admin WHERE id = $id";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deletedesigner($id){
	global $conn;

	//query delete data

	$query = "DELETE FROM designer WHERE designerID = $id";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deleterecipe($id){
	global $conn;

	//query delete data

	$query = "DELETE FROM recipes WHERE id = $id";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function deletefeedback($id){
	global $conn;

	//query delete data

	$query = "DELETE FROM review WHERE id = $id";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

 ?>

