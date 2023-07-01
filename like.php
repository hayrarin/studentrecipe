<?php
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Check if the recipe ID is provided
if (!isset($_GET['id'])) {
    // Redirect to the previous page if ID is not provided
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Retrieve the recipe ID from the query string
$id = $_GET['id'];

// Check if the recipe exists
$recipeQuery = "SELECT * FROM recipes WHERE id = $id";
$recipeResult = mysqli_query($conn, $recipeQuery);
$recipeRow = mysqli_fetch_assoc($recipeResult);

if (!$recipeRow) {
    // Redirect to the previous page if recipe does not exist
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Check if the recipe is already liked by the user
$userID = $_SESSION['user_id'];
$likeQuery = "SELECT * FROM likes WHERE user_id = $userID AND recipe_id = $id";
$likeResult = mysqli_query($conn, $likeQuery);
$isLiked = mysqli_num_rows($likeResult) > 0;

// Handle like/unlike action
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'like') {
        // Like the recipe
        $likeInsertQuery = "INSERT INTO likes (user_id, recipe_id) VALUES ($userID, $id)";
        mysqli_query($conn, $likeInsertQuery);
    } elseif ($action === 'unlike') {
        // Unlike the recipe
        $likeDeleteQuery = "DELETE FROM likes WHERE user_id = $userID AND recipe_id = $id";
        mysqli_query($conn, $likeDeleteQuery);
    }
    
    // Redirect to the previous page after the action is performed
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Like Recipe</title>
</head>
<body>
    <h2>Like Recipe</h2>
    
    <h3><?php echo $recipeRow['name']; ?></h3>
    
    <?php if ($isLiked) : ?>
        <p>You have liked this recipe.</p>
        <form action="like.php?id=<?php echo $id; ?>" method="post">
            <input type="hidden" name="action" value="unlike">
            <button type="submit">Unlike</button>
        </form>
    <?php else : ?>
        <p>You have not liked this recipe.</p>
        <form action="like.php?id=<?php echo $id; ?>" method="post">
            <input type="hidden" name="action" value="like">
            <button type="submit">Like</button>
        </form>
    <?php endif; ?>
</body>
</html>
