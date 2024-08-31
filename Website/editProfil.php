<?php 

	session_start();
	include 'init.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
function getSingleValue($con, $sql, $parameters){
    $q = $con->prepare($sql);
    $q->execute($parameters);
    return $q->fetchColumn();
}
$userid = getSingleValue($con, "SELECT UserID FROM users WHERE username=?", [$_SESSION['user']]);

$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

$stmt->execute(array($userid));

$row = $stmt->fetch();

$count = $stmt->rowCount();

if ($count > 0) { ?>

    <h1 class="text-center">Edit My Informations</h1>
    <div class="container">
        <form class="form-horizontal" action="UpdateProfile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="userid" value="<?php echo $userid ?>" />
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
                </div>
            </div>
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                    <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="full" value="<?php echo $row['FullName']; }?>" class="form-control"x />
                </div>
            </div>
            <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                </div>
            </div>
        </form>
    </div>


<?php include $tpl . 'footer.php'; ?>