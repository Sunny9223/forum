<?php
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">Forum</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Top Categories
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    $sql = "SELECT * FROM `categories`";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<a class="dropdown-item" href="threadlist.php?catid='. $row['category_id'] .'">'. $row['category_name'] .'</a>';  
    }
    echo '</div>
</li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php">Contact</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php">About</a>
    </li>
  </ul>
  <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-success my-2 mx-2 my-sm-0" type="submit">Search</button>';
    session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  echo ' <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Loggedin ID">'. $_SESSION['useremail'] .'
  </button>
  <a href="partials/_logout.php" class="btn btn-danger my-2 mx-2 my-sm-0" type="submit">Logout</a>'; 
}
else{
echo '
<button class="btn btn-outline-danger my-2 my-sm-0 mx-2" type="button" data-toggle="modal" data-target="#loginModal">Login</button>
<button class="btn btn-outline-info my-2 my-sm-0" type="button" data-toggle="modal" data-target="#signupModal">Signup</button>
';
}
    echo '
    </form>
</div>
</nav>';

include "partials/_loginModal.php";
include "partials/_signupModal.php";
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true") {
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Now you can login.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}

else {
  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="false") {
    $showError = $_GET['error'];
    if ($_GET['error'] != 'false') {
      echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
      <strong>Error!</strong> '.$showError.'.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
  }
}
if (isset($_GET['loginsuccess'])) {
  $loginSuccess = $_GET['loginsuccess'];
  if ($loginSuccess != 'true') {
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Error!</strong> ' . $loginSuccess . '.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>'; 
  }
}
?>