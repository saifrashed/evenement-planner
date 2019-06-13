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


                <div class="col-xs-12 col-md-12 activity-timeline">
                    <h2>Planning</h2>
                    <div class="col-xs-12">
                        <?php echo $activity->getMemberActivities($_GET['activity_id'], $_SESSION['id']); ?>
                    </div>
                </div>

        </div>
    </div>

<?php } ?>

<?php
require "./footer.php";
?>
