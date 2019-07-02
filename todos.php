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

            <div class="col-xs-12 col-md-10 window-title">
                <h2><?php echo $activity->getActivityTitle($_GET['activity_id']) ?></h2>
            </div>

            <div class="col-xs-12 col-md-10 control-window">

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Taken</h2>
                    <div class="col-xs-12 todo-selection">
                        <?php echo $activity->getMemberActivities($_GET['activity_id'], $_SESSION['id'], $_SESSION['role']); ?>
                    </div>
                </div>


                <div class="col-xs-12 col-md-6  activity-toolbar">

                    <div class="col-xs-12 activity-controls">
                        <h2>Acties</h2>
                        <div class="col-xs-12 activity-actions">
                            <h3 class="selected-title"></h3>

                            <form action="includes/form_handling.php" method="GET">
                            <input type="hidden" name="operation" value="update_status">
                            <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id'] ?>">
                            <input type="hidden" name="activity_id" value="<?php echo $_GET['activity_id'] ?>">


                                <button type="submit" class="btn btn-primary" name="status" value="1">Bezig</button>
                            <button type="submit" class="btn btn-primary" name="status" value="2">In wacht</button>
                            <button type="submit" class="btn btn-primary" name="status" value="0">Klaar</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <h2>Taak</h2>
                        <div class="col-xs-12 todo-description">
                            <?php
                            if ($_GET['todo_id']) {
                                echo $activity->getDescription($_GET['todo_id']);
                            } else {
                                echo 'Selecteer een taak.';
                            }
                            ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

<?php } ?>

<?php
require "./footer.php";
?>
