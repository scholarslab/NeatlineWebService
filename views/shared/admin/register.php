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

queue_js('jquery.complexify.min');
queue_js('complexify');
queue_css('complexify');
?>

<?php
echo $this->partial('admin/_header.php', array(
    'prefix' => 'Neatline Web Service',
    'title' => 'Register'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
    </div>

    <div class="row">

        <div class="span4">
            <h2>Create an Account</h2>
            <p>To get started, enter a username, password,
               and email address.</p>
            <p>We'll never give your email address away except to comply
                with the law. For more information, read our <a href="terms-of-service">Terms of Service</a>.
        </div>

        <div class="span12">
            <p class="intro">Welcome to the Neatline Sandbox! This is a hosted, demo version of
                Neatline that lets you build simple exhibits on modern-geography base layers.
                If you like what you see, head over to the <a href="http://23.21.98.97/plugins/neatline/">Neatline download page</a>
                and get the plugin for <a href="http://omeka.org/">Omeka</a>.</p>
            <?php echo $this->partial('admin/forms/_register.php', array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'confirm' => $confirm,
                'errors' => $errors
            )); ?>
        </div>

    </div>

</div>

