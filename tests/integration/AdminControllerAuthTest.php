<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller authentication redirecting tests.
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

class NeatlineWebService_AdminControllerAuthTest extends NWS_Test_AppTestCase
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
     * All pages that require credentialing should redirect an anonymous user to
     * the login view.
     *
     * @return void.
     */
    public function testRedirectAnonymousUserToLogin()
    {

        // ** /exhibits
        $this->dispatch(NLWS_SLUG . 'admin/exhibits');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'admin/login');

        // ** /add
        $this->dispatch(NLWS_SLUG . 'admin/add');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'admin/login');

        // ** /edit
        $this->dispatch(NLWS_SLUG . 'admin/edit');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'admin/login');

        // ** /delete
        $this->dispatch(NLWS_SLUG . 'admin/delete');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'admin/login');

        // ** /logout
        $this->dispatch(NLWS_SLUG . 'admin/logout');
        $this->assertRedirectTo('/' . NLWS_SLUG . 'admin/login');

    }

    /**
     * /login and /register should redirect a logged-in user to /exhibits.
     *
     * @return void.
     */
    public function testRedirectLoggedInUserToExhibits()
    {

        // Create a user, authenticate.
        $user =     $this->__user($username = 'david', $password = 'poesypure');
        $adapter =  new NeatlineAuthAdapter('david', 'poesypure');
        $auth =     Zend_Auth::getInstance();
        $auth->authenticate($adapter);

        // ** /login
        $this->dispatch(NLWS_SLUG . 'admin/login');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // ** /register
        $this->dispatch(NLWS_SLUG . 'admin/register');
        $this->assertRedirectTo(nlws_url('exhibits'));

    }

    /**
     * /exhibits should not redirect a logged-in user.
     *
     * @return void.
     */
    public function testNoRedirectLoggedInUser()
    {

        // Create a user, authenticate.
        $user =     $this->__user($username = 'david', $password = 'poesypure');
        $adapter =  new NeatlineAuthAdapter('david', 'poesypure');
        $auth =     Zend_Auth::getInstance();
        $auth->authenticate($adapter);

        // ** /exhibits
        $this->dispatch(NLWS_SLUG . 'admin/david/exhibits');
        $this->assertNotRedirect();

    }

}
