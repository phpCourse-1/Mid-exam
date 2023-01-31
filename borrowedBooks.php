<?php
include 'includes/header.php';
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$sql = "SELECT bB.borrower_name, bB.borrower_mobile, bB.end_date, b.name as book_name FROM borrowedBooks bB 
left join books b on b.id = bB.book_id";
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
                            <th class="text-center">Mobile</th>
                            <th class="text-center">Book</th>
                            <th class="text-center">Date</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            $i = 0;
                            while ($rows = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td class="text-center"><?= $i ?></td>
                                    <td class="text-center"><?= $rows['borrower_name'] ?></td>
                                    <td class="text-center"><?= $rows['borrower_mobile'] ?></td>

                                    <td class="text-center"><?= $rows['book_name'] ?></td>

                                    <td class="text-center"><?= $rows['end_date'] ?></td>
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
            <a href="borrow.php" class="btn btn-primary">Borrow Book</a>
        </div>
    </div>
</div>