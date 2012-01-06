<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Helpers.
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
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<?php

/**
 * Include admin stylesheets.
 *
 * @return void.
 */
function nlws_queueCss()
{

    // Custom CSS.
    queue_css('style');
    queue_css('bootstrap.xtra.min');
    queue_css('_overrides');

}

/**
 * Include .js in /add view.
 *
 * @return void.
 */
function nlws_queueAddJs()
{

    // Custom .js.
    queue_js('_constructAdd');
    queue_js('slugBuilder');

}

/**
 * Construct the error class (or lack thereof) for an errors array and a
 * specified key.
 *
 * @param string $errors    The errors array.
 * @param string $key       They key to check for.
 * @param string $class     The class to return.
 *
 * @return void.
 */
function nlws_getErrorClass($errors, $key, $class)
{

    return array_key_exists($key, $errors) ? $class : '';

}
