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
                <?php echo $activity->displaySingle($_GET['userId']); ?>
            </div>
        </div>
    </div>

<?php } ?>

<?php
require "./footer.php";
?>
