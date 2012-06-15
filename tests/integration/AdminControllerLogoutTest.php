<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests for logout action.
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

class NeatlineWebService_AdminControllerLogoutTest extends NWS_Test_AppTestCase
{

    /**
     * Instantiate the helper class, install the plugins, get the database.
     *
     * @return void.
     */
    public function setUp()
    {

        parent::setUp();
        $this->setUpPlugin();

    }

    /**
     * /logout should clear identity and redirect to login for a logged-in user.
     *
     * @return void.
     */
    public function testLogoutWithLoggedInUser()
    {

        // Create a user, authenticate.
        $user = $this->__user($username = 'david', $password = 'poesypure');
        $adapter = new NeatlineAuthAdapter('david', 'poesypure');
        $auth = Zend_Auth::getInstance();
        $auth->authenticate($adapter);

        // ** /logout
        $this->dispatch(NLWS_SLUG . 'logout');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'login');

        // Check for cleared identity.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /logout should redirect to login for an anonymous user.
     *
     * @return void.
     */
    public function testLogoutWithAnontmousUser()
    {

        // ** /logout
        $this->dispatch(NLWS_SLUG . 'logout');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'login');

    }

}
