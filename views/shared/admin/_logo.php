<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Neatline logo.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<h1 class="logo">

    <?php if (Zend_Auth::getInstance()->hasIdentity()): ?>
        <a href="<?php echo nlws_url('exhibits'); ?>">NEATLINE</a>
    <?php else: ?>
        <a href="<?php echo WEB_ROOT . '/' . NLWS_SLUG . 'admin'; ?>">NEATLINE</a>
    <?php endif; ?>

    <small>Plot your course in space and time.</small>

</h1>
