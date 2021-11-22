<!-- file : index.php
Nama : Nadira Fawziyya Masnur
NIM  : 18219004 -->

<?php
// Inisialisasi session
session_start();
 
// Mengecek apakah sudah login apa belum
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: successpage.php");
    exit;
}
 
// menggunakan config.php
require_once "config.php";

//fungsi untuk pop up message error
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
// Variabel diinisiasi kosong
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Proses saat data sudah disubmit
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    
    $password = trim($_POST["password"]);
    
    // Validatsi kredensial pengguna dengan di database tabel users
    if(empty($username_err) && empty($password_err)){
        // Mendapatkan select dari database
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user ke success page
                            header("location: successpage.php");
                        } else{
                            // Password tidak valid
                            $login_err = "Invalid username or password.";
                            alert("Invalid username or password.");
                        }
                    }
                } else{
                    // Username tidak ada
                    $login_err = "Invalid username or password.";
                    alert("Invalid username or password.");
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form - 18219004</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
		<div class="form">
			<div class="title">Login</div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<!-- untuk kolom username -->
				<div class="input_wrap">
					<label for="input_text">Your username</label>
					<div class="input_field">
						<input type="text" id="username-input" name="username" class="input <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
						<span class="invalid-feedback"><?php echo $username_err; ?></span>
					</div>
				</div>
				<!-- untuk kolom password -->
				<div class="input_wrap">
					<label for="input_password">Your password</label>
					<div class="input_field">
						<input type="password" id="password-input" name="password" class="input <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
              			<span class="invalid-feedback"><?php echo $password_err; ?></span>
					</div>
				</div>
				<div class="input_wrap">
					<!-- untuk tombol submit login -->
					<input type="submit" class="btn btn-primary" value="Login">
				</div>
			</form>
		</div>
	</div>
</body>
</html>