<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

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


// defines {{{

if (!defined('NLWS_PLUGIN_VERSION')) {
    define(
        'NLWS_PLUGIN_VERSION',
        get_plugin_ini('NeatlineWebService', 'version')
    );
}

if (!defined('NLWS_PLUGIN_DIR')) {
    define(
        'NLWS_PLUGIN_DIR',
        dirname(__FILE__)
    );
}

if (!defined('NLWS_SLUG')) {
    define(
        'NLWS_SLUG',
        get_plugin_ini('NeatlineWebService', 'saas_slug')
    );
}

// }}}


// requires {{{
require_once NLWS_PLUGIN_DIR . '/NeatlineWebServicePlugin.php';
require_once NLWS_PLUGIN_DIR . '/helpers/NeatlineWebServiceFunctions.php';
require_once NLWS_PLUGIN_DIR . '/helpers/NeatlineAuthAdapter.php';
require_once NLWS_PLUGIN_DIR . '/helpers/SampleExhibit.php';
require_once NLWS_PLUGIN_DIR . '/../Neatline/controllers/EditorController.php';
// }}}


/*
 * Run.
 */
new NeatlineWebServicePlugin;
