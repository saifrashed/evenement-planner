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


    <div class="container-fluid">
        <div class="row center-xs">
            <div class="col-xs-12 col-md-6 form-window">
                <?php

                switch ($_GET['fieldset']) {
                    case 'activity':
                        echo $admin->updateActivityForm($_GET['activity_id']);
                        break;
                    case 'user':
                        echo $admin->updateUserForm($_GET['user_id']);
                        break;
                    default:
                        echo 'wtf';
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
