<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-02-18
 * Time: 16:03
 */

require "./header.php";
?>


<?php if($_SESSION['admin']) { ?>

<div class="container-fluid">
    <div class="row">
        <p><?php echo '<pre>'.var_dump($_SESSION).'</pre>' ?></p>
    </div>
</div>

<?php } ?>

<?php
require "./footer.php";
?>
