  <main>
            <h1>Contact</h1>
            <?php
            if (!empty($reply)) {

                echo "<p class='notify'>$reply</p>";
            }

            unset($reply);
            ?> 
            <p>We'd love to hear from you. Let us know how we can meet your needs.</p>          
            <p>All fields are required.</p>


            <form method="post" action="index.php" id="contact_form">
                <fieldset>
                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstname" id="firstname" size="15" value="<?php echo $firstName; ?>" required><br>

                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" id="lastname" size="15" value="<?php echo $lastName; ?>" required><br>

                    <label for="email">Email Address:</label>
                    <input type="email" name="email" id="email" size="30" value="<?php echo $email; ?>" required><br>

                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" id="subject" size="60" value="<?php echo $subject; ?>" required><br>

                    <label for="message">Message</label><br>
                    <textarea name="message" id="message" rows="10" cols="60" required><?php echo $message; ?></textarea><br>

                    <p>Answer the following question to prove you are a human.</p>
                    <label for="captcha">What color is a red apple?</label>
                    <input type="text" name="captcha" id="captcha" size="5" required><br>

                    <label for="action">&nbsp;</label>
                    <input type="submit" name="action" id="action" value="Send">

                </fieldset>
            </form>
        </main>
