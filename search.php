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
    <!--Cerousel here-->
  

    <div class="result">
        <div class="container my-4" style="min-height:433px;">
            <h2 class="my-3 text-center">Search results for <em>"<?php echo $_GET['search']; ?>"</em></h2>
            <div class="media my-3">
                <div class="media-body">
                    <h5 class="mt-0">
                    <?php
    $query = $_GET['search'];
        $sql = "select * from threads where MATCH (thread_title, thread_desc) against ('$query')";
        $result = mysqli_query($conn, $sql);
        $sno = 1;
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {

            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $id = $row['thread_id'];
            echo '<p class="font-weight-bold my-2"><a href="thread.php?threadid='.$id .'" style="text-decoration: none;">'.$sno.'. '.$title.'</a></p>';
           echo $desc;
            $sno = $sno + 1;
            $noresult = false;
        }
    ?>
                    </h5>
                </div>
            </div>
    <?php
        if ($noresult) {
            echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">No results found!</h1>
          <p class="lead">It looks like there arent many great matches for your search
          <br>Tip: Try shortening your search to focus on the most important keywords or phrases..</p>
        </div>
      </div>';
        }
    ?>
        </div>
    </div>
    <!-- card starts from here -->
    <!-- <div class="container">
        <div class="row">
            <div class="col-md-4 my-2">
                <div class="card" style="width: 18rem;">
                <img src="https://source.unsplash.com/500x400/?coding,python" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- card starts from here -->

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