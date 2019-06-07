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
            <p><?php echo '<pre>' . var_dump($_SESSION) . '</pre>' ?></p>

            <div class="col-xs-12 col-md-10 control-window">

                <div class="col-xs-12 col-md-6 activity-display">
                    <h2>Activiteiten</h2>
                    <div class="col-xs-12 activity-selection">
                        <?php echo $activity->displayArchive(); ?>
                    </div>
                </div>


                <div class="col-xs-12 col-md-6  activity-toolbar">

                    <div class="col-xs-12 activity-controls">
                        <h2>Acties</h2>
                        <div class="col-xs-12 activity-actions">
                            <span>actions</span>
                        </div>
                        <div class="col-xs-12 activity-numbers">
                            <span>numbers</span>
                        </div>
                    </div>

                    <div class="col-xs-12 activity-members">
                        <h2>members</h2>
                        <div class="col-xs-12 activity-member-selection">
                            <div class="col-xs-12 activity-member-select">
                                <span>member</span>
                            </div>
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
