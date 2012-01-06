<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Registration template.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<form class="form-stacked" method="post">

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

        <div class="clearfix <?php echo nlws_getErrorClass($errors, 'email', 'error'); ?>">
            <label for="email">Email: *</label>
            <div class="input email">
                <input name="email" type="text" value="<?php echo $email; ?>" />
                <?php if (array_key_exists('email', $errors)): ?>
                    <span class="help-inline"><?php echo $errors['email']; ?></span>
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

        <div class="clearfix <?php echo nlws_getErrorClass($errors, 'confirm', 'error'); ?>">
            <label for="confirm">Confirm Password: *</label>
            <div class="input confirm">
                <input name="confirm" type="password" value="<?php echo $confirm; ?>" />
                <?php if (array_key_exists('confirm', $errors)): ?>
                    <span class="help-inline"><?php echo $errors['confirm']; ?></span>
                <?php endif; ?>
            </div>
        </div>

    </fieldset>

    <div class="actions">
        <button type="submit" class="btn primary large">Sign Up</button>
    </div>

</form>
