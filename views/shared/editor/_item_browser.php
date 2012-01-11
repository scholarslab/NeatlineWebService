<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Static markup for the item browser application.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      Scholars' Lab <>
 * @author      Bethany Nowviskie <bethany@virginia.edu>
 * @author      Adam Soroka <ajs6f@virginia.edu>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2011 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<div id="item-browser">

    <div id="items-list-header">

        <input type="text" placeholder="Search items" id="search-box" />
        <span id="search-cancel">x</span>

        <button id="new-item-button" class="btn icon add">New Item</button>

        <div class="columns">
            <div class="col-1 col-cell col-header"><span class="header"></span></div>
            <div class="col-2 col-cell col-header"><span class="header"></span></div>
        </div>

    </div>

    <div id="items-list-container"></div>

    <?php echo $this->partial('editor/_edit_form.php'); ?>

</div>
