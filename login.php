<?php 
    
    ob_start();
    
    session_start();

    include 'init.php';

    $pageTitle = 'Home';

	if (isset($_SESSION['Username'])) {
        header('Location: index.php'); 
        exit();
    }
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userName = $_POST['user'];
        $password = $_POST['password'];
        
		// Check If The User Exist In Database
		$stmt = $con->prepare("SELECT 
									`UserID`, `UserName`, `UserAcs`
								FROM 
                                    `user` 
								WHERE 
                                    `UserName` = ? 
								AND 
                                    `UserPassword` = ? ");
		$stmt->execute(array($userName, $password ));
		$row = $stmt->fetch();
        $count = $stmt->rowCount();
        
		// If Count > 0 This Mean The Database Contain Record About This Username
		if ($count > 0) {
			$_SESSION['Username'] = $row['User_name']; // Register Session Name
            $_SESSION['ID'] = $row['User_id']; // Register Session ID
            $_SESSION['UserAcs'] = $row['UserAcs'];
			header('Location: users.php'); // Redirect To Dashboard Page
			exit();
        } else {
            $loginError = "";
        }
	}
    include $tempDir . 'header.php';
?>

<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="<?=($imgDir)?>icon/logo.png" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form action="<?=($_SERVER['PHP_SELF'])?>" method="POST">
                            <div class="form-group">
                                <label>User</label>
                                <input class="au-input au-input--full" type="text" name="user" placeholder="User name">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                        </form>
                    <?php 
                    if (isset ($loginError)) {
                        echo '<div class="alert alert-danger" role="alert">
                        This User Or Password is Wrong!
                    </div>';
                    }
                    ?>
                    </div>
                </div>
            </div>

<?php

    include $tempDir . 'footer.php';

    ob_end_flush();

?>