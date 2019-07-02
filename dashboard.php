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
                <h2>Hallo, <?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname'] ?></h2>
            </div>

            <div class="col-xs-12 col-md-10 control-window">

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Jou activiteiten</h2>
                    <div class="col-xs-12 activity-selection">
                        <?php

                        switch ($_SESSION['role']) {
                            case 'beheerder':
                                echo $activity->displayArchive();
                                break;
                            case 'vrijwilliger':
                                echo $activity->displayVolunteerArchive($_SESSION['id']);
                                break;
                        }
                        ?>
                    </div>
                </div>


                <div class="col-xs-12 col-md-6  activity-toolbar">

                    <div class="col-xs-12 activity-controls">
                        <h2>Acties</h2>

                        <div class="col-xs-12 activity-actions">
                            <button class="btn btn-primary" onclick="viewTodos()" target="_blank">Taken</button>
                            <button class="btn btn-primary" onclick="viewSingle()" target="_blank">Details</button>
                        </div>
                    </div>

                    <div class="col-xs-12 activity-members">
                        <h2>Deelnemers</h2>
                        <div class="col-xs-12 activity-member-selection">
                            <?php
                            if ($_GET['activityId']) {
                                echo $activity->displayMembers($_GET['activityId']);
                            } else {
                                echo 'Selecteer een activiteit.';
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
