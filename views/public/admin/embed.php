<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Embed template.
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
    'title' => 'Embed'
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

            <h2>Embed <a href="<?php echo nlws_url('editor', $exhibit->slug); ?>">
                    <?php echo $exhibit->getExhibit()->name; ?></a></h2>

            <p>Click and drag on the "Height" and "Width" fields to customize the
                dimensions of the embedded exhibit.</p>

            <?php echo $this->partial('admin/forms/_embed.php'); ?>

            <iframe width="960" height="600" frameborder="0" scrolling="no"
                marginheight="0" marginwidth="0" id="embed-preview"
                src="<?php echo nlws_url('embedded', $exhibit->slug); ?>" />

        </div>

    </div>

</div>
