<?php
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}

if (isset($_GET['post_id'])) {

    include_once("admin/data/Post.php");
    include_once("admin/data/Comment.php");
    include_once("db_conn.php");
    $id = $_GET['post_id'];
    $post = getById($conn, $id);
    $comments = getCommentsByPostID($conn, $id);
    $categories = get5Categoies($conn);

    if ($post == 0) {
        header("Location: blog.php");
        exit;
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog - <?= $post['post_title'] ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="./css/blog.css">
    </head>

    <body>
        <?php
        include 'inc/NavBar.php';
        ?>

        <div class=" mt-5">
            <section class="d-flex">

                <main class="main-blog">

                    <div class="card main-blog-card mb-5">
                        <img src="upload/blog/<?= $post['cover_url'] ?>" class="card-img2" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post['post_title'] ?></h5>
                            <p class="card-text"><?= $post['post_text'] ?></p>
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
                                    <i class="fa-regular fa-comment"></i> comments (
                                    <?php
                                    echo CountByPostID($conn, $post['post_id']);
                                    ?>
                                    )

                                </div>
                                <small class="text-body-secondary"><?= $post['crated_at'] ?></small>
                            </div>

                            <form style="display: flex;" action="php/comment.php" method="post" id="comments">


                                <?php if (isset($_GET['error'])) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo htmlspecialchars($_GET['error']); ?>
                                    </div>
                                <?php } ?>

                                <?php if (isset($_GET['success'])) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo htmlspecialchars($_GET['success']); ?>
                                    </div>
                                <?php } ?>
                                <div style="width: 100%; margin-top:20px" class="mb-3">
                                    <input style="width: 100%;list-style: none; padding:10px" type="text" class="form__field" name="comment" placeholder="comment">
                                    <input type="text" class="form__field" name="post_id" value="<?= $id ?>" hidden>
                                </div>
                                <button type="submit" class="btcomment">Comment</button>
                            </form>
                            <hr>
                            <div>
                                <div class="comments">
                                    <?php if ($comments != 0) {
                                        foreach ($comments as $comment) {
                                            $u = getUserByID($conn, $comment['user_id']);
                                    ?>
                                            <div class="comment d-flex">
                                                <div style="padding:10px 2px;">
                                                    <img src="img/user-default.png" width="50" height="50">
                                                </div>
                                                <div class="p-2">
                                                    <div style="display: flex;">
                                                        <span style="padding: 5px 5px;color:#fff ;  background-color:#c4c4c4 ;border-radius:10px ">@<?= $u['username'] ?></span>
                                                        <span style="padding: 5px 5px; color:#c4c4c4" class="text-body-secondary"><?= $comment['crated_at'] ?></span>
                                                    </div>
                                                    <p><?= $comment['comment'] ?></p>

                                                </div>
                                            </div>

                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>


            </section>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    header("Location: blog.php");
    exit;
} ?>