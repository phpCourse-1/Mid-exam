<?php
include 'includes/header.php';
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = 0;
$title = 'Add';

if (isset($_GET['editid'])) {
    $id = $_GET['editid'];
    $title = 'Update';
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publish_date = $_POST['publish_date'];
    $image = $_FILES['image'];

    $errorArray = [];
    $query = "";

    if (empty($name)) {
        $errorArray[] = "Name is required";
    } else {
        if ($id == 0) {
            $query .= "'$name'";
        } else {
            $query .= "name='$name'";
        }
    }

    if (empty($publish_date)) {
        $errorArray[] = "Publish date is required";
    } else {
        if($publish_date > date('Y-m-d')){
            $errorArray[] = "Publish date must be in the past!";
        }
        if ($id == 0) {
            $query .= ",'$publish_date'";
        } else {
            $query .= ",publish_date='$publish_date'";
        }
    }

    if (empty($author)) {
        $errorArray[] = "Author is required";
    } else {
        if ($id == 0) {
            $query .= ",'$author'";
        } else {
            $query .= ",author='$author'";
        }
    }

    if ($image['error'] != 0 and $id == 0) {
        $errorArray[] = "Image is required";
    } else {
        if ($image['error'] == 0) {
            $image_tmp = $image['tmp_name'];
            $image_name = $image['name'];
            $image_type = $image['type'];

            $extensions = array('png', 'gif', 'jpeg');

            $image_ext = explode('.', $image_name);
            $image_extension = strtolower(end($image_ext));

            if (!in_array($image_extension, $extensions)) {
                $errorArray[] = 'Invalid Image Extensions!';
            } else {
                $new_name = rand(100000, 999999) . '.' . $image_extension;
                $target = 'uploads/' . $new_name;
                if ($id == 0) {
                    $query .= ",'$new_name'";
                } else {
                    $query .= ",image='$new_name'";
                }
            }
        }
    }

    if (count($errorArray) == 0) {
        if ($image['error'] == 0) {
            move_uploaded_file($image_tmp, $target);
        }
        if ($id == 0) {
            $sql = "INSERT INTO books (name, publish_date, author, image) VALUES ($query)";
        } else {
            $sql = "UPDATE books SET $query WHERE id=$id";
        }
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if ($id == 0) {
                $msg = "Book Added Successfully";
            } else {
                $msg = "Book Updated Successfully";
            }
        } else {
            $msg = "Error";
        }
    }
}

if ($id != 0) {
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $author = $row['author'];
            $publish_date = $row['publish_date'];
        }
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $title ?>Books</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($errorArray) and count($errorArray)) {
                                foreach ($errorArray as $error) {

                            ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <?= $error ?>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            if (isset($msg)) {
                            ?>
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        <?= $msg ?>
                                    </div>
                                <?php
                            }
                                ?>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="name form-control" value="<?php if (isset($name)) {
                                                                                                                    echo $name;
                                                                                                                } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="author">author</label>
                                    <input type="text" name="author" id="author" class="author form-control" value="<?php if (isset($author)) {
                                                                                                                        echo $author;
                                                                                                                    } ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="publish_date">Publish Date</label>
                                    <input type="date" name="publish_date" id="date" class="date form-control" value="<?php if (isset($publish_date)) {
                                                                                                                            echo $publish_date;
                                                                                                                        } ?>" />
                                </div>
                                <div>
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="image form-control">
                                </div>
                                <div class="card-footer">
                                    <input type="submit" name="submit" value="Save" class="btn btn-primary">
                                    <a href="books.php" class="btn btn-secondary">Back to Books</a>
                                </div>
                                </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</section>