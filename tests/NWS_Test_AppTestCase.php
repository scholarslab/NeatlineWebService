<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Testing helper class.
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


// Get plugin runners.
require_once '../NeatlineWebServicePlugin.php';
require_once '../../Neatline/NeatlinePlugin.php';


class NWS_Test_AppTestCase extends Omeka_Test_AppTestCase
{

    private         $_dbHelper;
    protected       $_isAdminTest = false;

    /**
     * Spin up the plugins and prepare the database.
     *
     * @return void.
     */
    public function setUpPlugin()
    {

        parent::setUp();

        $this->user = $this->db->getTable('User')->find(1);
        // $this->_authenticateUser($this->user);

        // Neatline broker.
        $neatline_plugin_broker = get_plugin_broker();
        $neatline_plugin_broker->setCurrentPluginDirName('Neatline');
        new NeatlinePlugin;

        // Neatline helper.
        $neatline_plugin_helper = new Omeka_Test_Helper_Plugin;
        $neatline_plugin_helper->setUp('Neatline');

        // Neatline Web Service broker.
        $nws_plugin_broker = get_plugin_broker();
        $nws_plugin_broker->setCurrentPluginDirName('NeatlineWebService');
        new NeatlineWebServicePlugin;

        // Neatline Web Service helper.
        $nws_plugin_helper = new Omeka_Test_Helper_Plugin;
        $nws_plugin_helper->setUp('NeatlineWebService');

        $this->_dbHelper = Omeka_Test_Helper_Db::factory($this->core);

    }

    /**
     * Helpers.
     */

    /**
     * Create a test user.
     *
     * @param string $username  The username.
     * @param string $password  The password.
     * @param string $email     The email address.
     *
     * @return Omeka_record $user The user.
     */
    public function __user(
        $username =         'david',
        $password =         'password',
        $email =            'dwm@uva.edu'
    )
    {

        $user = new NeatlineUser;
        $user->username =   $username;
        $user->email =      $email;
        $user->setPassword($password);
        $user->save();

        return $user;

    }

    /**
     * Create a test web exhibit.
     *
     * @param Omeka_recrd $user The parent user.
     * @param string $title     The title.
     * @param string $slug      The slug.
     * @param boolean $public   The public status.
     *
     * @return Omeka_record $user The exhibit.
     */
    public function __exhibit(
        $user =             null,
        $title =            'Test Exhibit',
        $slug =             'text-exhibit',
        $public =           true
    )
    {

        // If a user is not passed, create one.
        if ($user == null) {
            $user = $this->__user();
        }

        $exhibit = new NeatlineWebExhibit($user);
        $exhibit->slug =    $slug;
        $exhibit->public =  $public ? 1 : 0;
        $exhibit->save();

        return $exhibit;

    }

    /**
     * Get the most recently created Neatline-native exhibit.
     *
     * @return Omeka_record $exhibit    The exhibit.
     */
    public function __getMostRecentNeatlineExhibit()
    {

        // Get the table.
        $_exhibitsTable = $this->db->getTable('NeatlineExhibit');

        // Build the select.
        $select = $_exhibitsTable->getSelect()->order('added DESC');
        $exhibits = $_exhibitsTable->fetchObjects($select);
        $result = $_exhibitsTable->fetchObjects($select);

        return $result[0];

    }

}
