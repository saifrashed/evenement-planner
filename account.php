<?php
/**
 * Created by PhpStorm.
 * User: saifeddine
 * Date: 2019-02-18
 * Time: 16:03
 */

require "./header.php";

?>

<div class="form">
    <h1>Inloggen</h1>
    <p>
        Log in met jou persoonlijke account.
    </p>

    <form action='includes/registration.php' method='POST' class="register-form">

        <?php
        if (isset($_GET['status'])) {
            echo '<span class="status">' . $_GET['status'] . '</span>';
        }
        ?>

        <input type="text" name="fname" placeholder="First name" maxlength="50"/>
        <input type="text" name='lname' placeholder="Last name" maxlength="50"/>
        <input type="password" name='password' placeholder="password" maxlength="50"/>
        <input type="email" name='email' placeholder="Email address" maxlength="50"/>
        <label> <input type="radio" name="gender" value="male"> Male</label>
        <label> <input type="radio" name="gender" value="female"> Female</label>

        <button type="submit">Registreren</button>
        <p class="form-message">Al geregistreerd? <a id="login-toggle">Sign In</a></p>
    </form>

    <form action="includes/login.php" method="POST" class="login-form">
        <?php
        if (isset($_GET['status'])) {
            echo '<span class="status">' . $_GET['status'] . '</span>';
        }
        ?>
        <span class="login-message"><?php ?></span>
        <input type="email" name="email" placeholder="Email"/>
        <input type="password" name="password" placeholder="Password"/>
        <button>Login</button>
        <!--<p class="form-message">Niet geregistreerd? <a id="login-toggle">Meld je aan!</a></p>-->
    </form>
</div>

<?php

require "./footer.php";

?>
