<?php
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Dashboard - Users</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/side.css">
        <link rel="stylesheet" href="../css/blog.css">

    </head>

    <body>
        <?php
        $key = "thideptrai";
        include "inc/side-nav.php";
        include_once("data/User.php");
        include_once("../db_conn.php");
        $users = getAll($conn);

        ?>

        <div class="main-table">
            <h3 class="mb-3">All Users
                <a href="../signup.php" class="btn btn-success">Add New</a>
            </h3>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-warning">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php } ?>
            <?php if ($users != 0) { ?>
                <table class="table t1 table-bordered">
                    <thead>
                        <tr>

                            <th scope="col">Full Name</th>
                            <th scope="col">username</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>

                                <td><?= $user['fname'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td>
                                    <a href="user-delete.php?user_id=<?= $user['id'] ?>" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></a>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert alert-warning">
                    Empty!
                </div>
            <?php } ?>
        </div>
        </section>
        </div>
        <script>
            var navList = document.getElementById('navList').children;
            navList.item(0).classList.add("active");
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>

    </html>

<?php } else {
    header("Location: ../admin-login.php");
    exit;
} ?>