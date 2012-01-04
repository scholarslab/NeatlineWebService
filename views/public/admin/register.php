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

<?php
echo $this->partial('admin/_header.php', array(
    'prefix' => 'Neatline Web Service',
    'title' => 'Register'
));
?>

<div class="container">

    <!-- Logo. -->
    <?php echo $this->partial('admin/_logo.php'); ?>

    <div class="row">

        <div class="span4">
            <h2>Create an Account</h2>
            <p>Welcome to Neatline! To get started, enter a username, password,
               and email address.</p>
            <p>We'll never give your email address away. For more information,
               read our <a href="">Privacy Policy</a>.
        </div>

        <div class="span12">
            <form class="form-stacked">

                <fieldset>

                    <div class="clearfix">
                        <label for="username">Username: *</label>
                        <div class="input">
                            <input name="username" type="text" />
                        </div>
                    </div>

                    <div class="clearfix">
                        <label for="password">Password: *</label>
                        <div class="input">
                            <input name="password" type="password" />
                        </div>
                    </div>

                    <div class="clearfix">
                        <label for="confirm">Confirm Password: *</label>
                        <div class="input">
                            <input name="password_confirm" type="password" />
                        </div>
                    </div>

                    <div class="clearfix">
                        <label for="email">Email: *</label>
                        <div class="input">
                            <input name="email" type="text" />
                        </div>
                    </div>

                </fieldset>

                <div class="actions">
                    <button type="submit" class="btn primary large">Sign Up</button>
                </div>

            </form>
        </div>

    </div>

</div>

