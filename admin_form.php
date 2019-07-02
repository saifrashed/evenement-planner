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
                        echo $admin->displayActivityForm($_GET['activity_id']);
                        break;
                    case 'user':
                        echo $admin->displayUserForm($_GET['user_id']);
                        break;
                    case 'add_activity':
                        echo $admin->addActivityForm();
                        break;
                    case 'add_user':
                        echo $admin->addUserForm();
                        break;
                    case 'add_todo':
                        echo $admin->addTodoForm();
                        break;
                    default:
                        echo 'ERROR 404';
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
