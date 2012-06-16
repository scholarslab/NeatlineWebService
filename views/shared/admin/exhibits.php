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

    <div class="row">

        <div class="span16">

            <!--<h2 class="clearfix">Browse Exhibits</h2>-->
            <a class="no-underline" href="<?php echo nlws_url('add'); ?>">
                <button id="new-exhibit-button" class="btn large primary icon alternative arrowup">New Exhibit</button>
            </a>

            <?php if ($exhibits): ?>

            <table id="exhibits-table">
                <thead>
                    <tr>
                        <th>exhibit</th>
                        <th>modified</th>
                        <th>items</th>
                        <th>public</th>
                        <th>edit</th>
                    </tr>
                </thead>
                <?php foreach ($exhibits as $exhibit): ?>
                    <tr>
                        <td>
                            <a class="exhibit-title" href="<?php echo nlws_show_url($exhibit->slug); ?>"><?php echo $exhibit->getExhibit()->name; ?></a>
                            <div class="exhibit-slug">/<?php echo $exhibit->slug; ?></div>
                            <span class="action bold"><a href="<?php echo nlws_url('edit', $exhibit->slug); ?>">edit details</a> |</span>
                            <span class="action danger"><a href="<?php echo nlws_url('delete', $exhibit->slug); ?>">delete</a></span>
                        </td>
                        <td><?php echo nlws_formatDate($exhibit->modified); ?></td>
                        <td><?php echo $exhibit->getNumberOfRecords(); ?></td>
                        <td><?php echo $exhibit->public ? 'yes' : 'no'; ?></td>
                        <td>
                            <a class="no-underline" href="<?php echo nlws_url('editor', $exhibit->slug); ?>">
                                <button id="edit-exhibit-button" class="btn primary icon alternative">Edit</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php else: ?>
            <h4 class="no-exhibits">You don't have any exhibits yet. Click "New Exhibit" to get started!</h4>
        <?php endif; ?>

        </div>

    </div>

</div>
