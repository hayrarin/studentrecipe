<?php
//cek connection
require 'connection.php';

//ambil data dri URL
$id = $_GET["id"];

//query data berdasarkan id
$mhs = query("SELECT * FROM recipes WHERE id = $id")[0];

//cek button submit dh tekan atau belom
if (isset($_POST["submit"])) {

    //cek data berjaya diubah atau x
    if (update($_POST) > 0) {
        echo "<script>alert('Recipe updated successfully.')
            document.location.href='recipemanage.php'  
            </script>";
    } else {
        echo "<script>alert('Oops! Recipe failed to change. Try again. ')
        document.location.href='edit.php'
        </script>";
    }
}
?>

<?php include 'sidenavadmin.php'; ?>

<style>
    .center-heading {
        text-align: center;
        background-color: #cd4a4a;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
    }

    .form-container {
        width: 80%;
        margin: 0 auto;
        float: left;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .form-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: bold;
        font-size: 1.5em;
        padding-right: 10px;
        text-align: right;
    }

    .form-control {
        height: 40px;
        width: 100%;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-control-file {
        padding: 5px;
    }

    .form-actions {
        text-align: center;
        margin-top: 20px;
        clear: both;
    }

    .btn-primary,
    .btn-danger {
        text-align: center;
        background-color: #cd4a4a;
        color: white;
        font-size: 1.2em;
        border-radius: 5px;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover,
    .btn-danger:hover {
        background-color: #b33a3a;
    }
</style>

<div class="content">
    <div class="main">
        <h1 class="center-heading">Update Recipe</h1>
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $mhs["id"] ?>">
                <input type="hidden" name="oldpicture" value="<?= $mhs["picture"] ?>">

                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $mhs["name"] ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="prep_time">Preparation time:</label>
                    <input type="text" name="prep_time" id="prep_time" class="form-control" value="<?= $mhs["prep_time"] ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="cook_time">Cooking time:</label>
                    <input type="text" name="cook_time" id="cook_time" class="form-control" value="<?= $mhs["cook_time"] ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="ingredient">Ingredients:</label>
                    <textarea name="ingredient" id="ingredient" class="form-control" rows="8" cols="50"><?= $mhs["ingredient"] ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="steps">Steps:</label>
                    <textarea name="steps" id="steps" class="form-control" rows="8" cols="50"><?= $mhs["steps"] ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="picture">Current Image:</label>
                    <img src="img/<?= $mhs['picture'] ?>" width="300"><br>
                    <input type="file" name="picture" id="picture" class="form-control-file">
                </div>

                <div class="form-group">
                    <label class="form-label" for="video">Current Video:</label>
                    <?php if (!empty($mhs['video'])) : ?>
                        <video src="videos/<?= $mhs['video'] ?>" width="300" controls></video>
                    <?php else : ?>
                        <p>No video available.</p>
                    <?php endif; ?>
                    <input type="file" name="video" id="video" class="form-control-file">
                </div>

                <div class="form-group">
                    <label class="form-label" for="url">Video URL:</label>
                    <input type="text" name="video_url" id="url" class="form-control" placeholder="https://" value="<?= $mhs["video_url"] ?>">
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this recipe?');">Update recipe</button>
                </div>
            </form>
            <br>
            <div class="form-actions">
                <button class="btn btn-danger" onclick="location.href='updatepage.php'"><i class="fas fa-arrow-left"></i>Go back</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
