<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/blog.css">
</head>

<body>
    <div class="shadow w-1000 p-3 container box  d-flex ">
        <div>
            <img src="https://i.pinimg.com/564x/e5/d7/d0/e5d7d0d726e89ca394678689a46cf55d.jpg" alt="">
        </div>

        <form class=" form-blog" action="admin/admin-login.php" method="post">

            <h4 class="display-4  fs-1">ADMIN LOGIN</h4><br>
            <p> Chỉ dành cho Administrate</p>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <div class="mb-3">

                <input type="text" class="form-control" name="uname" placeholder="Username" value="<?php echo (isset($_GET['uname'])) ? htmlspecialchars($_GET['uname']) : "" ?>">
            </div>

            <div class="mb-3">

                <input type="password" placeholder="Password" class="form-control" name="pass">
            </div>

            <div class="sub-login"><button type="submit" class="btn btn-primary bt-login ">Login</button></div>
            <div class="footer">
                <a href="login.php" class="link-secondary">User Login</a>
            </div>

        </form>
    </div>
</body>

</html>