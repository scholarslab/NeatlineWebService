<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Terms of service.
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
    'title' => 'Terms of Service'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
    </div>

    <div class="row">
        <div class="span16">

            <h2>Purpose and Scope of this Site</h2>
            <p>This site has been created under the ownership and control of the University of Virginia Library to lower the technical bar necessary to evaluate the Neatline Omeka plugin created by the Scholars' Lab. Its purpose is to provide a short-term evaluation sandbox in which users can explore some features of the Neatline tool, and share their experiments with others. No submitted exhibits will be reviewed before being published online, but the Scholars' Lab does reserve the right to request revisions or remove any given exhibit. In other words, the Scholars' Lab Neatline Sandbox has been established to allow experimentation with the Neatline Omeka plugin, and does not constitute a forum for general expression.</p>

            <h2>Legal Responsibilities</h2>
            <p>You agree that it is your individual responsibility to adhere to all applicable legal requirements including copyright law, and that you have not posted content that is defamatory of or harmful to the legal rights of others. You represent and warrant that you either own or have received permission to post the all content submitted, or that your excerpts from the original works of others are consistent with fair use guidelines under US copyright law.</p>

            <h2>Publication Rules</h2>
            <p>All contributions to the Neatline sandbox environment are published under a Creative Commons Attribution-ShareAlike Public Use License. Under the terms of this license, you permit free distribution, display, and/or performance of your submitted works of authorship, so long as you are credited by name each time your content is utilized. This license does not interfere with your personal ability to reuse or republish content you post here, either in a commercial or noncommercial context.</p>

            <h2>Preservation</h2>
            <p>The University of Virginia Library does not promise backup, restoration, continued maintenance, or dedicated archiving of content created in this temporary sandbox environment. Any questions about these policies should be directed to Bethany Nowviskie, Director of Digital Research & Scholarship, UVa Library.</p>
            <p>YOUR CREATION OF A NEATLINE SANDBOX ACCOUNT INDICATES YOUR AGREEMENT WITH THE ABOVE TERMS.</p>

        </div>
    </div>

</div>
