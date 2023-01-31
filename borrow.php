<?php
include 'includes/header.php';
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * from books";
$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrower_name = $_POST['borrower_name'];
    $borrower_books = $_POST['borrower_books'];
    $borrower_mobile = $_POST['borrower_mobile'];
    $end_date = $_POST['end_date'];

    $errorArray = [];
    $query = "";

    if (empty($borrower_books)) {
        $errorArray[] = 'Borrower books is required';
    } else {
        $query .= $borrower_books . ',';
    }

    if (empty($borrower_name)) {
        $errorArray[] = 'Name is required';
    } else {
        $query .= '"' . $borrower_name . '",';
    }

    if (empty($borrower_mobile)) {
        $errorArray[] = 'Borrower mobile is required';
    } else {
        $query .= $borrower_mobile . ',';
    }

    if (empty($end_date)) {
        $errorArray[] = 'Date is required';
    } else {
        if ($end_date < date('Y-m-d')) {
            $errorArray[] = "End date must be in the future!";
        }
        $query .= '"' . $end_date . '"';
    }

    if (count($errorArray) == 0) {
        $sql = "Insert into borrowedBooks (book_id ,borrower_name,borrower_mobile, end_date) values ($query)";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $msg = 'Borrowed Successfully';
            header('Location: borrowedBooks.php');
        } else {
            $msg = 'Error';
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
                            <h3 class="card-title">Borrow Books</h3>
                        </div>
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

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="borrower_name">Borrower Name</label>
                                    <input type="text" name="borrower_name" id="name" class="name form-control">
                                </div>
                                <div class="form-group">
                                    <label for="borrower_books">Books</label>
                                    <select name="borrower_books" id="borrower_books" class="form-control borrower_books">
                                        <option value="">Choose Book</option>
                                        <?php
                                        if (mysqli_num_rows($result)) {
                                            while ($rows = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?= $rows['id'] ?>" <?php if (isset($borrower_books)) {
                                                                                        if ($rows['id'] == $borrower_books) {
                                                                                            echo 'selected';
                                                                                        }
                                                                                    } ?>><?= $rows['name'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="borrower_mobile">Borrower Mobile</label>
                                    <input type="text" name="borrower_mobile" id="date" class="date form-control" />
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="date" class="date form-control" />
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