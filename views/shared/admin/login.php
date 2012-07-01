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
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
    </div>

    <div class="row">

        <div class="span4">
            <h2>Login</h2>
            <p>Don't have an account? Head over to the <a href="register">Register</a>
               page and sign up!</p>
        </div>

        <div class="span12">
            <?php echo $this->partial('admin/_welcome.php'); ?>
            <?php echo $this->partial('admin/forms/_login.php', array(
                'username' => $username,
                'password' => $password,
                'errors' => $errors
            )); ?>
        </div>

    </div>

</div>
