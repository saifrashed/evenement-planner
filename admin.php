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


<?php if ($_SESSION['role']) { ?>

    <div class="container-fluid">
        <div class="row center-xs">
            <div class="col-xs-12 col-md-10 control-window">

                <p><?php echo '<pre>' . var_dump($_SESSION) . '</pre>' ?></p>
            </div>
        </div>
    </div>


<?php } ?>

<?php
require "./footer.php";
?>
