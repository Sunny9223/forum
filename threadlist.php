<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>iDiscuss - Coding forum</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $sno = $_POST['sno'];
           $th_title = $_POST['title'];
           $th_desc = $_POST['desc'];
           $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);
           $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);
           $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Our community will give you the answer shortly.   
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>
    <div class="container">
        <div class="jumbotron my-4">
            <h1 class="display-4">Welcome to <?php echo $catname ;?> forum!</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p> No Spam / Advertising / Self-promote in the forums. ...
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Remain respectful of other members at all times.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="container">
        <h2>Start a discussion</h2>
        <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {    
        echo '
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            <div class="form-group my-4">
                <label for="exampleInputEmail1">Title of the problem</label>
                <input type="text" class="form-control" name="title" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Write a short and clear title regarding the issue you
                    are facing.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Elobrate your concern</label>
                <input type="text" name="desc" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>';
    }
    else {
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h2 class="display-6">You have to login inorder to start the discussion.</h2>
        </div>
      </div>';
    }
    ?>
        <div class="container my-4" style="min-height:433px;">
            <h2 class="my-3">Browse Questions</h2>
            <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            echo '<div class="media my-3">
            <img src="img/userdefault.png" width="54px" class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">
                <p class="font-weight-bold my-2">'. $row2['user_email'] .' at '.$thread_time.'</p>
                <a href="thread.php?threadid='.$thread_id.'">'.$title.'</a></h5>
                '.$desc.'</div>
        </div>';
                
        }
        ?>
            <?php
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No threads found</p>
              <p class="lead">Be the first one to ask a question.</p>
            </div>
          </div>';  
        }
    ?>
        </div>
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