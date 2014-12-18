
<?php
include '/models/users.php';

if ($errorMessage) {
    echo $errorMessage;
}
?>

        <main>
            <div id="loginregister">
                <form action="/?action=registersubmit" method="POST" id="registerform">
                    <input type="hidden" name="actiontype" id="actiontype" value="" />
                    <fieldset>
                        <legend>Register a new account</legend>
                        First Name: <input type="text" name="firstname" id="firstname" size="15"  required><br />
                        Last Name: <input type="text" name="lastname" id="lastname" size="15" required><br />
                        Email Address: <input type="email" name="emailreg" id="emailreg" size="30" required><br />
                        Password: <input type="password" name="passwordreg1" id="passwordreg1" size="30"  required/><br />
                        Verify Password: <input type="password" name="passwordreg2" id="passwordreg2" size="30"  required/><br />
                        <button name="register" id="buttonRegister">Register</button>
                    </fieldset>
                </form>

                <br /><br />

                <form action="/?action=loginsubmit" method="POST" id="loginform">
                    <fieldset>
                        <legend>Login with existing account</legend>
                        Email Address: <input type="text" name="emaillogin" id="emaillogin" size="30" required/><br />
                        Password: <input type="password" name="passwordlogin" id="passwordlogin" size="30"  required/><br />
                        <button name="login" id="buttonLogin">Login</button>
                    </fieldset>
                </form>
            </div>
        </main>
