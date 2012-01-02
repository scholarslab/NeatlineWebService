<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Plugin runner. Define constants, instantiate the mamanger class.
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


// defines {{{
if (!defined('NEATLINE_WEB_SERVICE_PLUGIN_VERSION')) {
    define(
        'NEATLINE_WEB_SERVICEPLUGIN_VERSION',
        get_plugin_ini('NeatlineWebService', 'version')
    );
}

if (!defined('NEATLINE_WEB_SERVICE_PLUGIN_DIR')) {
    define(
        'NEATLINE_WEB_SERVICE_PLUGIN_DIR',
        dirname(__FILE__)
    );
}
// }}}


// requires {{{
require_once NEATLINE_WEB_SERVICE_PLUGIN_DIR . '/NeatlineWebServicePlugin.php';
// }}}


/*
 * Run.
 */
new NeatlineWebServicePlugin;
