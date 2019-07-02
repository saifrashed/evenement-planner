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

                <h2><?php echo $activity->getActivityTitle($_GET['activity_id']) ?></h2>


                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Informatie</h2>
                    <div class="col-xs-12 activity-selection" style="text-align: left; padding: 25px">
                        <ul style="font-size:1.5em;">
                            <li>Activiteit
                                naam: <?php echo $activity->activityDetail('activity_name', $_GET['activity_id']) ?></li>
                            <li>Activiteit
                                aangemaakt: <?php echo $activity->activityDetail('date_created', $_GET['activity_id']) ?></li>
                            <li>Activiteit
                                geplanned: <?php echo $activity->activityDetail('date_planned', $_GET['activity_id']) ?></li>
                            <li>Hoeveelheid leden: <?php echo $activity->amountMembers($_GET['activity_id']) ?> </li>
                            <li>Hoeveelheid taken: <?php echo $activity->amountTodos($_GET['activity_id']) ?> </li>


                        </ul>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Alle taken</h2>
                    <div class="col-xs-12 todo-selection" style="border-radius:25px;">
                        <?php echo $activity->getMemberActivities($_GET['activity_id'], $_SESSION['id'], 'beheerder'); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Beschrijving</h2>
                    <div class="col-xs-12 todo-selection" style="border-radius:25px;">
                        <?php echo $activity->activityDetail('activity_description', $_GET['activity_id']); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Alle leden</h2>
                    <div class="col-xs-12 todo-selection" style="border-radius:25px;">
                        <?php echo $activity->displayMembers($_GET['activity_id']); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php } ?>

<?php
require "./footer.php";
?>
