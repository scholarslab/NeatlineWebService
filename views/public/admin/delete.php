<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Delete template.
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
    'title' => 'Delete Exhibit'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
        <?php echo $this->partial('admin/_logout.php', array('user' => $user)); ?>
    </div>

    <div class="row">

        <div class="span16">

            <h2>Are you sure?</h2>

            <p>This will permanently delete "<strong><?php echo $exhibit->getExhibit()->name; ?></strong>"
               and associated geospatial and temporal data.</p>

            <?php echo $this->partial('admin/forms/_delete.php'); ?>

        </div>

    </div>

</div>
