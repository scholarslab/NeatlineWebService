<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Add template.
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
    'title' => 'Create Exhibit'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
        <?php echo $this->partial('admin/_logout.php', array('user' => $user)); ?>
    </div>

    <div class="row">

        <div class="span4">
            <h2>Create Exhibit</h2>
            <p>Enter a title, URL slug, and set whether or not the exhibit
               should publicly visible.</p>
        </div>

        <div class="span12">
            <?php echo $this->partial('admin/forms/_add.php', array(
                'user' => $user,
                'errors' => $errors,
                'title' => $title,
                'slug' => $slug,
                'public' => $public,
                'description' => $description,
                'submit' => 'Create'
            )); ?>
        </div>

    </div>

</div>

<script>
    NeatlineWebService = {
        web_root: '<?php echo $webRoot; ?>'
    };
</script>
