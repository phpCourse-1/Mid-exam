<?php
include 'includes/header.php';
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['deleteid'])) {
    $deleteid = $_GET['deleteid'];
    $sql = "DELETE FROM books WHERE id = '$deleteid'";
    $result = mysqli_query($conn, $sql);
}

$sql = "SELECT id, name, author, publish_date, image FROM books";
$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Books</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Publish Date</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Delete</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $i = 0;
                            while ($rows = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $rows['name'] ?></td>
                                    <td class="text-center"><?= $rows['publish_date'] ?></td>
                                    <td class="text-center"><?= $rows['author'] ?></td>
                                    <td class="text-center">
                                        <img width="50" src="uploads/<?= $rows['image'] ?>" alt="uploaded" />
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" href="addBook.php?editid=<?= $rows['id'] ?>">
                                            <i class="fa fa-edit text-center"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger btn-sm"  onClick="return confirm('Are u sure?')" href="books.php?deleteid=<?= $rows['id'] ?>">
                                            <i class="fa fa-trash text-center"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="addBook.php" class="btn btn-primary">Add Book</a>
        </div>
    </div>
</div>