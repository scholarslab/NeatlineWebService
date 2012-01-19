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
 * Include .js in /embed view.
 *
 * @return void.
 */
function nlws_queueEmbedJs()
{

    // Custom .js.
    queue_js('_constructEmbed');
    queue_js('embedBuilder');
    queue_js('editor/utilities/_integer_dragger');

}

/**
 * Construct the error class (or lack thereof) for an errors array and a
 * specified key.
 *
 * @param string $errors    The errors array.
 * @param string $key       The key to check for.
 * @param string $class     The class to return.
 *
 * @return void.
 */
function nlws_getErrorClass($errors, $key, $class)
{
    return array_key_exists($key, $errors) ? $class : '';
}

/**
 * Build webservice url.
 *
 * @param string $action        The name of the action.
 * @param string $slug          The exhibit slug.
 * @param boolean $noRoot       If true, just return the relative path.
 *
 * @return void.
 */
function nlws_url(
    $action =       null,
    $slug =         null,
    $noRoot =       false
)
{

    // URL root for all actions.
    $path = NLWS_SLUG . '/' . nlws_getUsername();

    // If action passed.
    if (!is_null($action)) {
        $path .= '/' . $action;
    }

    // If slug passed.
    if (!is_null($slug)) {
        $path .= '/' . $slug;
    }

    return $noRoot ? $path : WEB_ROOT . '/' . $path;

}

/**
 * Get the username of the current user.
 *
 * @return string $username     The username.
 */
function nlws_getUsername()
{

    $auth = Zend_Auth::getInstance();
    $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));

    return $auth->getIdentity()->username;

}

/**
 * Format datetime.
 *
 * @param string $date          The date in datetime.
 *
 * @return string $date         The formatted date.
 */
function nlws_formatDate($date)
{

    $date = new DateTime($date);
    return $date->format('F j, Y \a\t g:i a');

}
