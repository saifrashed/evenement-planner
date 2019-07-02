<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-02-18
 * Time: 16:03
 */

require "./header.php";

$activity = new Activity();

?>


<?php if ($_SESSION) { ?>

    <div class="container-fluid">
        <div class="row center-xs">
            <div class="col-xs-12 col-md-10 control-window">

                <h2><?php echo $activity->getActivityTitle($_GET['activity_id'])?></h2>


                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Taken</h2>
                    <div class="col-xs-12 activity-selection">
                        <?php
                            echo $activity->displayTodos($_GET['activity_id'], $_GET['cat_id']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<?php
require "./footer.php";
?>
