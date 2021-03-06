<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

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

    // Hooks.
    private static $_hooks = array(
        'install',
        'uninstall',
        'define_routes',
        'nlws_new_user',
        'admin_theme_header',
        'public_theme_header',
        'config_form',
        'config',
        'define_acl'
    );

    // Filters.
    private static $_filters = array();

    // Public-facing admin actions.
    private static $_adminActions = array(
        'nlwsAdmin',
        'nlwsAdminExhibitSlug',
        'nlwsAdminAnon'
    );

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

        delete_option('web_service_home_page');

    }

    public function config()
    {
        set_option(
            'web_service_home_page',
            (int)(boolean)$_POST['web_service_home_page']
        );
    }

    public function configForm()
    {
        include 'config_form.php';
    }

    /**
     * Stub for future upgrades
     *
     * @param string $oldVersion Older version number
     * @param string $newVersion New version number
     *
     * @return void
     */
    public function upgrade($oldVersion, $newVersion)
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

        // Default webservice slug.
        $router->addRoute(
            'nlwsSlug',
            new Zend_Controller_Router_Route(
                NLWS_SLUG,
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'admin',
                    'action'        => 'exhibits'
                )
            )
        );

        // Public view.
        $router->addRoute(
            'nlwsShow',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . ':user/:slug',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'public',
                    'action'        => 'show'
                )
            )
        );

        // Admin slug.
        $router->addRoute(
            'nlwsAdmin',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:user/:action',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'admin',
                    'action'        => 'exhibits'
                )
            )
        );

        // Admin anonymous slug.
        $router->addRoute(
            'nlwsAdminAnon',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:action',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'admin',
                    'action'        => 'exhibits'
                )
            )
        );

        // Exhibit-specific slug.
        $router->addRoute(
            'nlwsAdminExhibitSlug',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:user/:action/:slug',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'admin'
                )
            )
        );

        // Editor.
        $router->addRoute(
            'nlwsEditorIndex',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:user/editor/:slug',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'editor',
                    'action'        => 'index'
                )
            )
        );

        // Editor ajax.
        $router->addRoute(
            'nlwsEditorAction',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:user/editor/ajax/:action',
                array(
                    'module'        => 'neatline-web-service',
                    'controller'    => 'editor'
                )
            )
        );

        // ** Clobber Simile __history__.html asset.
        $router->addRoute(
            'nlwsSimileHistoryOverride',
            new Zend_Controller_Router_Route(
                NLWS_SLUG . 'nl-admin/:user/editor/__history__.html',
                array(
                    'module'        => 'neatline',
                    'controller'    => 'data'
                )
            )
        );

        // Optionall, take control of top-level route.
        if (get_option('web_service_home_page') && !is_admin_theme()) {
            $router->addRoute(
                'nlws_home_page',
                new Zend_Controller_Router_Route(
                    '/',
                    array(
                        'module'     => 'neatline-web-service',
                        'controller' => 'admin',
                        'action'     => 'exhibits'
                    )
                )
            );
        }

    }

    /**
     * Install sample exhibit to new user's account.
     *
     * @param Omeka_Record $user The new use.
     *
     * @return void
     */
    public function nlwsNewUser($user)
    {
        nlws_installSampleExhibit($user);
    }

    /**
     * Queue file assets by route for administrative views.
     *
     * @return void
     */
    public function adminThemeHeader($request)
    {

        $exhibit = get_current_neatline();

        // Get the route.
        $routeName = Zend_Controller_Front
            ::getInstance()
            ->getRouter()
            ->getCurrentRouteName();

        // Admin.
        if (in_array($routeName, self::$_adminActions)) {

            nlws_queueCss();

            // ** /add or /edit
            if (in_array(
                $request->getActionName(),
                array('add', 'edit'))) {
                    nlws_queueAddJs();
                }

            // ** /embed
            if ($request->getActionName() == 'embed') {
                nlws_queueEmbedJs();
            }

        }

        // Editor.
        else if ($routeName == 'nlwsEditorIndex') {
            neatline_queueNeatlineAssets($exhibit);
            neatline_queueEditorAssets();
        }

    }

    /**
     * Queue file assets by route for public views.
     *
     * @param Zend_Request $request Request 
     *
     * @return void
     */
    public function publicThemeHeader($request)
    {
        $exhibit = get_current_neatline();

        // Get the route.
        $routeName = Zend_Controller_Front
            ::getInstance()
            ->getRouter()
            ->getCurrentRouteName();

        // Fullscreen.
        if ($routeName == 'nlwsFullscreen') {
            neatline_queueFullscreenAssets();
            neatline_queueNeatlineAssets($exhibit);
        }

        // Embedded.
        if ($routeName == 'nlwsEmbed') {
            neatline_queueEmbedAssets();
            neatline_queueNeatlineAssets($exhibit);
        }

    }

    /**
     * This clobbers the ACL of the Neatline plugin.
     *
     * @return void
     * @author Eric Rochester <erochest@virginia.edu>
     **/
    public function defineAcl($acl)
    {
        $resourceList = array(
            'Neatline_Index' => array(
                'add',
                'browse',
                'edit',
                'query',
                'delete',
                'show',
                'showNotPublic',
                'udi',
                'simile',
                'openlayers'
              ),
            'Neatline_Editor' => array(
                'index',
                'items',
                'form',
                'save',
                'status',
                'order',
                'positions',
                'arrangement',
                'focus',
                'mapsettings',
                'timelinesettings',
                'resetstyles',
                'dcdefault'
            )
        );

        foreach ($resourceList as $resource => $privileges) {
            $acl->allow(null, $resource);
        }
    }

}
