<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Forum - Coding forum</title>
</head>
<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $id = $_GET['threadid'];
            $sno = $_POST['sno'];
           $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_date`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Thanks for your response.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>
    <div class="container my-4">
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;  
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $id = $row['thread_user_id'];
            $findSQL = "SELECT user_email FROM `users` where sno = '$id'";
            $findResult = mysqli_query($conn, $findSQL);
            $row = mysqli_fetch_assoc($findResult);
            $noResult = false; 
            echo '
            <div class="jumbotron">
            <h1 class="display-4">'.$title.'</h1>
            <hr class="my-4">
            <p class="lead">'.$desc.'</p>
            <p>If you know the correct answer of the question you are welsome to answer this question.</p>
            <p><b>Posted by: '. $row['user_email'] .'</b></p>
            </div>';
        }
    ?>
    <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {    
        echo ' <div class="container">
        <h2>Post a Comment</h2>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type a comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>';
        }
        else {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h2 class="display-6">You have to login inorder to give comment.</h2>
            </div>
          </div>';
        }
    ?>
        <h2 class="my-3">Discussions</h2>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $desc = $row['comment_content'];
            $comment_date = $row['comment_date'];
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<div class="media my-3">
            <img src="img/userdefault.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0">'. $row2['user_email'] .' at '.$comment_date.'</p>
            '.$desc.'</div>
        </div>';
            
        }
        ?>
    </div>
       <div class="container">
       <?php
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No comment found</p>
              <p class="lead">Be the first one to ask a question.</p>
            </div>
          </div>';  
        }
    ?>
       </div>
    <?php include "partials/_footer.php"; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>