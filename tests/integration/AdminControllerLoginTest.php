<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests for the login flow.
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

class NeatlineWebService_AdminControllerLoginTest extends NWS_Test_AppTestCase
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
     * /login should render the login form.
     *
     * @return void.
     */
    public function testLoginFormDisplay()
    {

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the form.
        $this->assertQuery('input[name="username"]');
        $this->assertQuery('input[name="password"]');

    }

    /**
     * /login should render errors for and empty username.
     *
     * @return void.
     */
    public function testLoginErrorsEmptyUsername()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the error classe.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_absent')
        );

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /login should render errors an empty password.
     *
     * @return void.
     */
    public function testLoginErrorsEmptyPassword()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the error class.
        $this->assertQuery('div.error input[name="password"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.password span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_absent')
        );

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /login should render errors for a non-existent username.
     *
     * @return void.
     */
    public function testLoginErrorsUsernameDoesNotExist()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the error class.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_does_not_exist')
        );

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /login should render errors for an incorrect password.
     *
     * @return void.
     */
    public function testLoginErrorsPasswordIncorrect()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   'poesyimpure'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the error class.
        $this->assertQuery('div.error input[name="password"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.password span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_incorrect')
        );

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /login should persist a username on form re-display.
     *
     * @return void.
     */
    public function testLoginUsernamePersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the value.
        $this->assertQuery('div.username input[value="david"]');

    }

    /**
     * /login should persist a password on form re-display.
     *
     * @return void.
     */
    public function testLoginPasswordPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'poesypure'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');

        // Check for the value.
        $this->assertQuery('div.password input[value="poesypure"]');

    }

    /**
     * /login should redirect to exhibits view and log the user in with valid
     * credentials.
     *
     * @return void.
     */
    public function testLoginSuccess()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   'poesypure'
            )
        );

        // Hit the route and check for redirect.
        $this->dispatch(NLWS_SLUG . 'nl-admin/login');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // Login.
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());

    }

}
