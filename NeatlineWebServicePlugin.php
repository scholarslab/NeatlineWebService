<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Manager class.
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

class NeatlineWebServicePlugin
{

    private static $_hooks = array(
        'install',
        'uninstall',
        'define_routes'
    );

    private static $_filters = array();

    /**
     * Get database, call addHooksAndFilters().
     *
     * @return void
     */
    public function __construct()
    {

        $this->_db = get_db();
        self::addHooksAndFilters();

    }

    /**
     * Iterate over hooks and filters, define callbacks.
     *
     * @return void
     */
    public function addHooksAndFilters()
    {

        foreach (self::$_hooks as $hookName) {
            $functionName = Inflector::variablize($hookName);
            add_plugin_hook($hookName, array($this, $functionName));
        }

        foreach (self::$_filters as $filterName) {
            $functionName = Inflector::variablize($filterName);
            add_filter($filterName, array($this, $functionName));
        }

    }

    /**
     * Hook callbacks:
     */

    /**
     * Install. Create _neatlines table.
     *
     * @return void.
     */
    public function install()
    {

    }

    /**
     * Uninstall.
     *
     * @return void.
     */
    public function uninstall()
    {

    }

    /**
     * Register routes.
     *
     * @param object $router Router passed in by the front controller.
     *
     * @return void
     */
    public function defineRoutes($router)
    {

        $router->addConfig(new Zend_Config_Ini(NEATLINE_PLUGIN_DIR
            .'/routes.ini', 'routes'));

    }

}
