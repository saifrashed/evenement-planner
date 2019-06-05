<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-02-18
 * Time: 16:03
 */

require "./header.php";
?>


<?php if($_SESSION) { ?>

<div class="container-fluid">
    <div class="row">
        <h1>dashboard</h1>
        <p><?php echo '<pre>'.var_dump($_SESSION).'</pre>' ?></p>
    </div>
</div>

<?php } else { ?>

<div class="container-fluid">
    <div class="row">
        <h1>You are not logged in... Please <a href="account.php">log in</a> to see this page.</h1>
    </div>
</div>

<?php }; ?>



<?php
require "./footer.php";
?>
