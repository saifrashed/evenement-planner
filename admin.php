<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-02-18
 * Time: 16:03
 */

require "./header.php";

$admin = new Admin();

?>


<?php if ($_SESSION['role'] == 'beheerder') { ?>

    <div class="container-fluid admin-statistics">

        <div class="row center-xs">
            <div class="col-xs-4 col-md-4 statistics-col">
                <div class="statistics-container">
                    <h2>Amount products</h2>
                    <span class="statistics-result"><?php echo 0; ?></span>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 statistics-col">
                <div class="statistics-container">
                    <h2>Products sold</h2>
                    <span class="statistics-result"><?php echo 0; ?></span>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 statistics-col">
                <div class="statistics-container">
                    <h2>Average prices</h2>
                    <span class="statistics-result statistics-price"><?php echo 0; ?></span>
                </div>
            </div>
        </div>

        <div class="row center-xs">
            <div class="col-xs-12 col-md-12 control-window">


                <div class="col-xs-12 col-md-12">
                    <a class="btn btn-primary" href="?tableData=activities">Activiteiten</a>
                    <a class="btn btn-primary" href="?tableData=users">Gebruikers</a>

                    <?php

                        switch($_GET['tableData']) {
                            case 'users':
                                echo $admin->displayUserTable();
                                break;
                            case 'activities':
                                echo $admin->displayActivityTable();
                                break;
                            default:
                                 echo $admin->displayActivityTable();
                                break;
                        }

                    ?>
                </div>

            </div>
        </div>

<?php } ?>

<?php
require "./footer.php";
?>
