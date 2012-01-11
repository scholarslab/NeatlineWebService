<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Exhibits browse template.
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
    'title' => 'Exhibits'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
        <?php echo $this->partial('admin/_logout.php', array('user' => $user)); ?>
    </div>

    <a class="no-underline" href="<?php echo nlws_url('add'); ?>">
        <button id="new-exhibit-button" class="btn large primary icon alternative arrowup">New Exhibit</button>
    </a>

    <div class="row">

        <div class="span16">

            <?php if ($exhibits): ?>

            <table id="exhibits-table">
                <thead>
                    <tr>
                        <th>exhibit</th>
                        <th># items</th>
                        <th>public</th>
                    </tr>
                </thead>
                <?php foreach ($exhibits as $exhibit): ?>
                    <tr>
                        <td>
                            <a class="exhibit-title" href="<?php echo nlws_url('editor', $exhibit->slug); ?>"><?php echo $exhibit->getExhibit()->name; ?></a>
                            <div class="exhibit-slug">/<?php echo $exhibit->slug; ?></div>
                            <span class="action bold"><a href="<?php echo nlws_url('edit', $exhibit->slug); ?>">edit</a> |</span>
                            <span class="action"><a href="">embed</a> |</span>
                            <span class="action danger"><a href="">delete</a></span>
                        </td>
                        <td><?php echo $exhibit->getNumberOfRecords(); ?></td>
                        <td><?php echo $exhibit->public ? 'yes' : 'no'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php endif; ?>

        </div>

    </div>

</div>
