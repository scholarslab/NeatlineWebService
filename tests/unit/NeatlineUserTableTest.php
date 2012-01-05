<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * User table tests.
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

class Neatline_NeatlineUserTableTest extends NWS_Test_AppTestCase
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
     * usernameIsAvailable() should return false when there is an existing
     * user with the supplied name.
     *
     * @return void.
     */
    public function testUsernameIsAvailableWhenFalse()
    {

        // Create a user.
        $user = $this->__user($username = 'david');

        // Test for false.
        $this->assertFalse($this->_usersTable->usernameIsAvailable('david'));

    }

    /**
     * usernameIsAvailable() should return true when there is not an existing
     * user with the supplied name.
     *
     * @return void.
     */
    public function testUsernameIsAvailableWhenTrue()
    {

        // Create a user.
        $user = $this->__user($username = 'david');

        // Test for true.
        $this->assertTrue($this->_usersTable->usernameIsAvailable('eric'));

    }

    /**
     * emailIsAvailable() should return false when there is an existing
     * user with the supplied address.
     *
     * @return void.
     */
    public function testEmailIsAvailableWhenFalse()
    {

        // Create a user.
        $user = $this->__user($email = 'dwm@uva.edu');

        // Test for false.
        $this->assertFalse($this->_usersTable->emailIsAvailable('dwm@uva.edu'));

    }

    /**
     * emailIsAvailable() should return true when there is not an existing
     * user with the supplied address.
     *
     * @return void.
     */
    public function testEmailIsAvailableWhenTrue()
    {

        // Create a user.
        $user = $this->__user($email = 'dwm@uva.edu');

        // Test for true.
        $this->assertTrue($this->_usersTable->emailIsAvailable('eric@uva.edu'));

    }

    /**
     * findByUsername() should return the Omeka_record user record when there is
     * a user with the passed name.
     *
     * @return void.
     */
    public function testFindByUsernameWhenUsernameExists()
    {

        // Create a user.
        $user = $this->__user($username = 'david');

        // Get out the user and check identity.
        $retrievedUser = $this->_usersTable->findByUsername('david');
        $this->assertEquals($user->id, $retrievedUser->id);

    }

    /**
     * findByUsername() should return false when there is no user with the
     * passed name.
     *
     * @return void.
     */
    public function testFindByUsernameWhenUsernameDoesNotExist()
    {

        // Try to get non-existent user.
        $retrievedUser = $this->_usersTable->findByUsername('david');
        $this->assertFalse($retrievedUser);

    }

    /**
     * _validateLogin() should throw errors for empty username.
     *
     * @return void.
     */
    public function testValidateLoginEmptyUsername()
    {

        // Register with empty fields.
        $errors = $this->_usersTable->_validateLogin(
            '',
            '');

        // Check for the errors.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_absent'),
            $errors['username']
        );

    }

    /**
     * _validateLogin() should throw errors for empty password.
     *
     * @return void.
     */
    public function testValidateLoginEmptyPassword()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Register with empty fields.
        $errors = $this->_usersTable->_validateLogin(
            'david',
            '');

        // Check for the errors.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'password_absent'),
            $errors['password']
        );

    }

    /**
     * _validateLogin() should throw errors for a non-existent username.
     *
     * @return void.
     */
    public function testValidateLoginUsernameDoestNotExist()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Register with empty fields.
        $errors = $this->_usersTable->_validateLogin(
            'eric',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_does_not_exist'),
            $errors['username']
        );

    }

    /**
     * _validateLogin() should throw errors for an incorrect password.
     *
     * @return void.
     */
    public function testValidateLoginPasswordIncorrect()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Register with empty fields.
        $errors = $this->_usersTable->_validateLogin(
            'david',
            'poesyimpure');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'password_incorrect'),
            $errors['password']
        );

    }

    /**
     * _validateLogin() should return an empty array for valid credentials.
     *
     * @return void.
     */
    public function testValidateLoginSuccess()
    {

        // Create a user, set username.
        $user = $this->__user($username = 'david', $password = 'poesypure');

        // Register with empty fields.
        $errors = $this->_usersTable->_validateLogin(
            'david',
            'poesypure');

        // Check for the error.
        $this->assertEquals($errors, array());
        $this->assertEquals(count($errors), 0);

    }

}
