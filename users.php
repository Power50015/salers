<?php 
    
    ob_start();
    
    session_start();

    include 'init.php';
    if ($_SESSION['UserAcs'] != 1) {
        header('Location: login.php'); 
		exit();
    }

    $pageTitle = 'Users';

    include $tempDir . 'header.php';

    include $tempDir . 'nav.php';

    if (!isset($_GET['action'])) {
        $_GET['action'] = "manegment";
    }elseif ($_GET['action'] == "add") {
        ?>

<div class="container-fluid">
    <div class="section__content section__content--p30">
        <div class="login-content">
            <div class="login-logo">
                <a href="#">
                    <img src="<?=($imgDir)?>icon/logo.png" alt="CoolAdmin">
                </a>
            </div>
            <div class="login-form">
                <form action="<?=($_SERVER['PHP_SELF'])?>?action=insert" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input required class="au-input au-input--full" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input required class="au-input au-input--full" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input  class="au-input au-input--full" type="tel" name="phone" placeholder="phone">
                    </div>
                    <div class="form-group">
                        <label>Job Title</label>
                        <input class="au-input au-input--full" type="text" name="jobTite" placeholder="job title">
                    </div>
                    <div class="login-checkbox">
                        <label>
                            <input type="checkbox" required name="aggree">Agree the terms and policy
                        </label>
                    </div>
                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="insert">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

    }elseif($_GET['action'] == "insert") {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userName = $_POST['username'];
            $userPassword = sha1($_POST['password']);
            $userPhone = $_POST['phone'];
            $jobTite = $_POST['jobTite'];
            $aggree = $_POST['aggree'];
            do {
                $userId = randomString();
            }while(cheak('`UserID`', 'user', "`UserID` = '$userId'"));
            if (cheak('`UserName`', 'user', "`UserName` = '$userName'")) {
                $error = array ("This user is Fucker");
            }
            if (cheak('`UserPhone`', 'user', "`UserPhone` = '$userPhone'")) {
                $error = array ("This user is son of bitch");
            }
            if(!isset($error)){
                $stmt = $con->prepare("INSERT INTO `user` (`UserID`, `UserName`, `UserPassword`, `UserPhone`, `UserJob`)
VALUES(:sidu, :suser, :spass, :sphone, :sjob)");
            $stmt->execute(array(
                'sidu'  => $userId,
                'suser' => $userName,
                'spass' => $userPassword,
                'sphone' => $userPhone,
                'sjob' => $jobTite,
            ));
            header('Location: users.php'); 
            exit();
            }else {
                if (isset($error)) {
                    foreach($error as $x){
                        echo '<div class="alert alert-danger" role="alert">
                        ' .$x . '
                    </div>';
                    }
                }
            }
        }
    }
    if ($_GET['action'] == "manegment") {
        ?>       
        <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="title-1 m-b-25 d-inline">Management Users</h2>
            <a href="users.php?action=add" class="btn btn-success float-right">Add User</a>
            <div class="table-responsive table--no-card m-b-40">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>name</th>
                            <th>Phone</th>
                            <th>Job Title</th>
                            <th>Edit User</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $stmt = $con->prepare("SELECT  * FROM  user ORDER BY `user`.`UserAddDate` ASC");

                        $stmt->execute();
            
                       $get = $stmt->fetchAll(); 

                        foreach ($get as $x){
                            $random = randomChars();

                        
                    ?>
                        <tr>
                            <td><?=($x['UserID'])?></td>
                            <td><?=($x['UserName'])?></td>
                            <td class="text-right"><?=($x['UserPhone'])?></td>
                            <td class="text-right"><?=($x['UserJob'])?></td>
                            <td class="text-right"><a href="users.php?action=update&user=<?=($x['UserID'])?>" class="btn btn-primary" >Edit</a>
                           <?php 
                           if ($x['UserAcs'] != 1) {?>
                            <button type="button" class="btn btn-danger mb-1" data-toggle="modal" data-target="#<?=($random)?>"> Remove </button></td>
                            <!-- modal static -->
                            <div class="modal fade" id="<?=($random)?>" tabindex="-1" role="dialog" aria-labelledby="<?=($random)?>Label" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="<?=($random)?>Label">Remove User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                Do you Wont Remove This User?
                                                <?=($x['UserID'])?>
                                                <?=($x['UserName'])?>

                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <a href="users.php?action=delete&user=<?=($x['UserID'])?>" class="btn btn-primary">Confirm</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal static -->
                           <?php } ?>
                        </tr>
<?php 
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php
    }elseif ($_GET['action'] == "delete") {
        if(isset($_GET['user'])){
            if(!empty($_GET['user'])){
                $Duser = $_GET['user'];
                if (cheak('`UserID`', 'user', "`UserID` = '$Duser'")) {
                // sql to delete a record
                $sql = "DELETE FROM user WHERE `UserID`= '" . $Duser . "'" ;
                // use exec() because no results are returned
                $con->exec($sql);
                header('Location: users.php'); 
                exit();
                }else {
                    header('Location: users.php'); 
                exit();
                }
            }else {
                header('Location: users.php'); 
                exit();
            }
        }else {
            header('Location: users.php'); 
                exit();
        }
    }elseif ($_GET['action'] == "update") {
        if(isset($_GET['user'])){
            if(!empty($_GET['user'])){
                $Uuser = $_GET['user'];
                if (cheak('`UserID`', 'user', "`UserID` = '$Uuser'")) {
                    $stmt = $con->prepare("SELECT  * FROM  user Where `UserID` = '" .$Uuser."'");
                    $stmt->execute();
                    $myUser = $stmt->fetch();
                    ?>
                    <div class="container-fluid">
    <div class="section__content section__content--p30">
        <div class="login-content">
            <div class="login-logo">
                <a href="#">
                    <img src="<?=($imgDir)?>icon/logo.png" alt="CoolAdmin">
                </a>
            </div>
            <div class="login-form">
                <form action="<?=($_SERVER['PHP_SELF'])?>?action=edit&user=<?=($myUser['UserID'])?>" method="POST">
                    <div class="form-group">
                        <label>User ID</label>
                        <input required class="au-input au-input--full" disabled type="text" name="username" placeholder="Username" value="<?=($myUser['UserID'])?>">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input required class="au-input au-input--full" type="text" name="username" placeholder="Username" value="<?=($myUser['UserName'])?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input required class="au-input au-input--full" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input  class="au-input au-input--full" type="tel" name="phone" placeholder="phone" value="<?=($myUser['UserPhone'])?>">
                    </div>
                    <div class="form-group">
                        <label>Job Title</label>
                        <input class="au-input au-input--full" type="text" name="jobTite" value="<?=($myUser['UserJob'])?>" placeholder="job title" >
                    </div>
                    <div class="login-checkbox">
                        <label>
                            <input type="checkbox" required name="aggree">Agree the terms and policy
                        </label>
                    </div>
                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>
                    <?php
                } 
            } 
            } 
            }elseif ($_GET['action'] == "edit") {
                    if(isset($_GET['user'])){
                        if(!empty($_GET['user'])){
                                $userName = $_POST['username'];
                                $userPassword = sha1($_POST['password']);
                                $userPhone = $_POST['phone'];
                                $jobTite = $_POST['jobTite'];
                                $sql = "UPDATE user SET `UserName`='".$userName."',`UserPassword` = '".$userPassword."',`UserPhone` = '".$userPhone."',`UserJob` = '".$jobTite."' WHERE `UserID`='".$_GET['user']."'";
                                // Prepare statement
                                $stmt = $con->prepare($sql);
                                // execute the query
                                $stmt->execute();
                                header('Location: users.php'); 
                                exit();
                        }else {
                            header('Location: users.php'); 
                            exit();
                        }
                    }else {
                        header('Location: users.php'); 
                        exit();
                    }
                }else {
                    header('Location: users.php'); 
                    exit();
                }

    include $tempDir . 'footer.php';
    if(isset($error)){
        header("refresh:2;users.php'");
        exit();
    }
    ob_end_flush();

?>