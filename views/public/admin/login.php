<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Login template.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<?php
echo $this->partial('admin/_header.php', array(
    'prefix' => 'Neatline Web Service',
    'title' => 'Login'
));
?>

<div class="container">

    <!-- Logo. -->
    <?php echo $this->partial('admin/_logo.php'); ?>

    <div class="row">

        <div class="span4">
            <h2>Login</h2>
            <p>Don't have an account? Head over to the <a href="register">Register</a>
               page and sign up!</p>
        </div>

        <div class="span12">
            <form method="post" class="form-stacked">

                <fieldset>

                    <div class="clearfix <?php echo nlws_getErrorClass($errors, 'username', 'error'); ?>">
                        <label for="username">Username: *</label>
                        <div class="input username">
                            <input name="username" type="text" value="<?php echo $username; ?>" />
                            <?php if (array_key_exists('username', $errors)): ?>
                                <span class="help-inline"><?php echo $errors['username']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="clearfix <?php echo nlws_getErrorClass($errors, 'password', 'error'); ?>">
                        <label for="password">Password: *</label>
                        <div class="input password">
                            <input name="password" type="password" value="<?php echo $password; ?>" />
                            <?php if (array_key_exists('password', $errors)): ?>
                                <span class="help-inline"><?php echo $errors['password']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                </fieldset>

                <div class="actions">
                    <button type="submit" class="btn primary large">Submit</button>
                </div>

                <p>Forgot your password? <a href="resetpassword">Click here</a>.

            </form>

        </div>

    </div>

</div>
