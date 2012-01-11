<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests for the register flow.
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

class NeatlineWebService_AdminControllerRegisterTest extends NWS_Test_AppTestCase
{

    /**
     * Instantiate the helper class, install the plugins, get the database.
     *
     * @return void.
     */
    public function setUp()
    {

        // Roll up the environment.
        parent::setUp();
        $this->setUpPlugin();

        // Get the database and table.
        $this->db = get_db();
        $this->_usersTable = $this->db->getTable('NeatlineUser');

    }

    /**
     * /register should render the registration form.
     *
     * @return void.
     */
    public function testRegisterFormDisplay()
    {

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the form.
        $this->assertQuery('input[name="username"]');
        $this->assertQuery('input[name="password"]');
        $this->assertQuery('input[name="confirm"]');
        $this->assertQuery('input[name="email"]');

    }

    /**
     * /register should render errors for submission with empty fields.
     *
     * @return void.
     */
    public function testRegisterErrorsEmptyFields()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error classes.
        $this->assertQuery('div.error input[name="username"]');
        $this->assertQuery('div.error input[name="password"]');
        $this->assertQuery('div.error input[name="email"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_absent')
        );

        $this->assertQueryContentContains(
            'div.password span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_absent')
        );

        $this->assertQueryContentContains(
            'div.email span.help-inline',
            get_plugin_ini('NeatlineWebService', 'email_absent')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for unavailable username.
     *
     * @return void.
     */
    public function testRegisterErrorsUsernameTaken()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david');

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Count users.
        $_userCount = $this->_usersTable->count();

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_taken')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 1);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for too-long username.
     *
     * @return void.
     */
    public function testRegisterErrorsUsernameTooLong()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'itlittleprofitsthatanidlekingbythisstillhearth',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_too_long')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for not-alphanumeric username.
     *
     * @return void.
     */
    public function testRegisterErrorsUsernameNotAlnum()
    {

        // Prepare the request with username with spaces.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'user with spaces',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_alnum')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // Prepare the request with username with illegal character.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'userwithillegalchar!',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="username"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_alnum')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for invalid email address.
     *
     * @return void.
     */
    public function testRegisterErrorsEmailInvalid()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      'invalid'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Count users.
        $_userCount = $this->_usersTable->count();

        // Check for the error class.
        $this->assertQuery('div.error input[name="email"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.email span.help-inline',
            get_plugin_ini('NeatlineWebService', 'email_invalid')
        );

        // +0.
        $this->assertEquals($this->_usersTable->count(), $_userCount);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for unavailable email address.
     *
     * @return void.
     */
    public function testRegisterErrorsEmailTaken()
    {

        // Create a user, set username.
        $user = $this->__user($email = 'dwm@uva.edu');

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      'dwm@uva.edu'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Count users.
        $_userCount = $this->_usersTable->count();

        // Check for the error class.
        $this->assertQuery('div.error input[name="email"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.email span.help-inline',
            get_plugin_ini('NeatlineWebService', 'email_taken')
        );

        // +0.
        $this->assertEquals($this->_usersTable->count(), $_userCount);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for too-short password.
     *
     * @return void.
     */
    public function testRegisterErrorsPasswordTooShort()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'x',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="password"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.password span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_too_short')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for missing password confirmation.
     *
     * @return void.
     */
    public function testRegisterErrorsPasswordConfirmEmpty()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'poesypure',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="confirm"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.confirm span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_confirm_absent')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should render error for non-matching password confirm.
     *
     * @return void.
     */
    public function testRegisterErrorsPasswordConfirmMismatch()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'poesypure',
                'confirm' =>    'poesyimpure',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the error class.
        $this->assertQuery('div.error input[name="confirm"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.confirm span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_confirm_mismatch')
        );

        // No user created.
        $this->assertEquals($this->_usersTable->count(), 0);

        // No login.
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());

    }

    /**
     * /register should persist an username on form re-display.
     *
     * @return void.
     */
    public function testRegisterUsernamePersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the value.
        $this->assertQuery('div.username input[value="david"]');

    }

    /**
     * /register should persist an email on form re-display.
     *
     * @return void.
     */
    public function testRegisterEmailPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      'dwm'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the value.
        $this->assertQuery('div.email input[value="dwm"]');

    }

    /**
     * /register should persist as password on form re-display.
     *
     * @return void.
     */
    public function testRegisterPasswordPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'poesypure',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the value.
        $this->assertQuery('div.password input[value="poesypure"]');

    }

    /**
     * /register should persist a password confirmation on form re-display.
     *
     * @return void.
     */
    public function testRegisterPasswordConfirmPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   'poesypure',
                'confirm' =>    'poesyimpure',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/register');

        // Check for the value.
        $this->assertQuery('div.confirm input[value="poesyimpure"]');

    }

    /**
     * /register should create new user with valid submission.
     *
     * @return void.
     */
    public function testRegisterSuccess()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   'david',
                'password' =>   'poesypure',
                'confirm' =>    'poesypure',
                'email' =>      'dwm@uva.edu'
            )
        );

        // Count users.
        $_userCount = $this->_usersTable->count();

        // Hit the route, check for redirect.
        $this->dispatch(NLWS_SLUG . '/register');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // +1.
        $this->assertEquals($this->_usersTable->count(), $_userCount+1);

        // Check record.
        $user = $this->_usersTable->find(1);
        $this->assertEquals($user->username, 'david');
        $this->assertEquals($user->email, 'dwm@uva.edu');
        $this->assertNotNull($user->password);
        $this->assertNotNull($user->salt);

        // Login.
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());

    }

}
