<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Add form.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<form id="embed-form" class="form-stacked">

    <fieldset>

        <div id="height-and-width">

            <div class="clearfix inline">
                <label>Width:</label>
                <div class="input">
                    <input name="title" type="text" />
                </div>
            </div>

            <div class="clearfix inline">
                <label>Height:</label>
                <div class="input">
                    <input name="title" type="text" />
                </div>
            </div>

        </div>

        <div class="clearfix">
            <label>Embed Code:</label>
            <div class="input">
                <textarea class="xxlarge" rows="3"></textarea>
                <span class="help-block">Copy and paste this code into any context where HTML is allowed.</span>
            </div>
        </div>

    </fieldset>

</form>
