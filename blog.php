<?php
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}
$notFound = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($_GET['search'])) {
            echo "search '" . htmlspecialchars($_GET['search']) . "'";
        } else {
            echo "Blog Page";
        } ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="./css/blog.css">
</head>

<body style="background-color: #393E46;">
    <?php
    include 'inc/NavBar.php';
    include_once("admin/data/Post.php");
    include_once("admin/data/Comment.php");
    include_once("db_conn.php");
    if (isset($_GET['search'])) {
        $key = $_GET['search'];
        $posts = serach($conn, $key);
        if ($posts == 0) {
            $notFound = 1;
        }
    } else {
        $posts = getAll($conn);
    }
    $categories = get5Categoies($conn);
    ?>
    <div class="category-slider">
        <div class="content">

            <img class="banner-header" src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/cd1060153471573.637049ca1dac9.png" alt="">




        </div>
        <div class="content">

            <img class="banner-header" src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/9da637177980777.64dfc151c60cd.jpg" alt="">



        </div>
        <div class="content">

            <img class="banner-header" src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/45701d178909635.64f04097d5754.png" alt="">




        </div>
        <div class="content">

            <img class="banner-header" src="https://mir-s3-cdn-cf.behance.net/project_modules/1400/c36b0c174501877.64a3ddeb8cacc.jpg" alt="">


        </div>

    </div>
    </div>
    <hr>
    <div class="container-nav ">

        <div class="asiden">
            <div class=" flex-category ">

                <?php foreach ($categories as $category) { ?>
                    <div class="list-category">
                        <a href="category.php?category_id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
                            <h4 style="color: white;"> <?php echo $category['category']; ?></h4>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <hr>
        <?php if ($posts != 0) { ?>
            <h1 class="display-4 mb-4 fs-3">
                <?php
                if (isset($_GET['search'])) {
                    echo "Search <b>'" . htmlspecialchars($_GET['search']) . "'</b>";
                } ?></h1>
            <main class="main-blog grid3">

                <?php foreach ($posts as $post) { ?>
                    <div class=" card-blog card main-blog-card mb-5">
                        <img src="upload/blog/<?= $post['cover_url'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post['post_title'] ?></h5>
                            <?php
                            $p = strip_tags($post['post_text']);
                            $p = substr($p, 0, 200);
                            ?>
                            <p class="card-text blog-p"><?= $p ?>...</p>

                            <a href="blog-view.php?post_id=<?= $post['post_id'] ?>" class="btn btn-primary">Read more</a>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="react-btns">
                                    <?php
                                    $post_id = $post['post_id'];
                                    if ($logged) {
                                        $liked = isLikedByUserID($conn, $post_id, $user_id);


                                        if ($liked) {
                                    ?>
                                            <i class="fa fa-thumbs-up liked like-btn" post-id="<?= $post_id ?>" liked="1" aria-hidden="true"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-thumbs-up like like-btn" post-id="<?= $post_id ?>" liked="0" aria-hidden="true"></i>
                                        <?php }
                                    } else { ?>
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                    <?php } ?>
                                    Likes (
                                    <span><?php
                                            echo likeCountByPostID($conn, $post['post_id']);
                                            ?></span> )
                                    <a href="blog-view.php?post_id=<?= $post['post_id'] ?>#comments">
                                        <i class="fa fa-comment" aria-hidden="true"></i> Comments (
                                        <?php
                                        echo CountByPostID($conn, $post['post_id']);
                                        ?>
                                        )
                                    </a>
                                </div>
                                <small class="text-body-secondary"><?= $post['crated_at'] ?></small>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </main>
        <?php } else { ?>
            <main class="main-blog p-2">
                <?php if ($notFound) { ?>
                    <div class="alert alert-warning">
                        dữ liệu
                        <?php echo " - <b>key = '" . htmlspecialchars($_GET['search']) . "'</b>" ?>
                        không tồn tại
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning">
                        No posts yet.
                    </div>
                <?php } ?>
            </main>
        <?php } ?>

    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".like-btn").click(function() {
                var post_id = $(this).attr('post-id');
                var liked = $(this).attr('liked');

                if (liked == 1) {
                    $(this).attr('liked', '0');
                    $(this).removeClass('liked');
                } else {
                    $(this).attr('liked', '1');
                    $(this).addClass('liked');
                }
                $(this).next().load("ajax/like-unlike.php", {
                    post_id: post_id
                });
            });
        });
    </script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script>
        const rr = ScrollReveal({
            origin: 'top',
            distance: '30px',
            duration: 2000,
            reset: true
        });

        rr.reveal(`.main-blog-card`, {
            interval: 200
        })
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script src="./js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>