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


class NeatlineWebServicePlugin
{

    private static $_hooks = array(
        'install',
        'uninstall',
        'define_routes',
        'define_acl',
        'admin_theme_header'
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
     * Install. Create table for _neatline_users.
     *
     * @return void.
     */
    public function install()
    {

        // Users table.
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->_db->prefix}neatline_users` (
                `id`                    int(10) unsigned not null auto_increment,
                `username`              varchar(30) NOT NULL UNIQUE,
                `password`              varchar(40) NOT NULL,
                `salt`                  varchar(16) NULL,
                `email`                 varchar(80) NOT NULL,
                 PRIMARY KEY (`id`)
               ) ENGINE=innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $this->_db->query($sql);

        // Exhibits table.
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->_db->prefix}neatline_web_exhibits` (
                `id`                    int(10) unsigned not null auto_increment,
                `user_id`               int(10) unsigned NULL,
                `exhibit_id`            int(10) unsigned NULL,
                `slug`                  varchar(100) NOT NULL UNIQUE,
                `public`                tinyint(1) NOT NULL,
                 PRIMARY KEY (`id`)
               ) ENGINE=innodb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

        $this->_db->query($sql);

    }

    /**
     * Uninstall.
     *
     * @return void.
     */
    public function uninstall()
    {

        // Drop the users table.
        $sql = "DROP TABLE IF EXISTS `{$this->_db->prefix}neatline_users`";
        $this->_db->query($sql);

        // Drop the exhibits table.
        $sql = "DROP TABLE IF EXISTS `{$this->_db->prefix}neatline_web_exhibits`";
        $this->_db->query($sql);

    }

    /**
     * Register routes.
     *
     * @param object $router    Router passed in by the front controller.
     *
     * @return void
     */
    public function defineRoutes($router)
    {

        // Webservice application slug.
        $router->addRoute(
            'nlwsAdmin',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . '/:action',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'admin',
                    'action'        => 'login'
                    )
                )
            );

    }

    /**
     * Define ACL.
     *
     * @param Zend_Acl $acl     Router passed in by the front controller.
     *
     * @return void
     */
    public function defineAcl($acl)
    {


    }

    /**
     * Queue file assets.
     *
     * @return void
     */
    public function adminThemeHeader($request)
    {

        // Get the route.
        $routeName = Zend_Controller_Front
            ::getInstance()
            ->getRouter()
            ->getCurrentRouteName();

        // Admin.
        if ($routeName == 'nlwsAdmin') {
            nlws_queueCss();

            // ** /add
            if ($request->getActionName() == 'add') {
                nlws_queueAddJs();
            }

        }


    }

}
