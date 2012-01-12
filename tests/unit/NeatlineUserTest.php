<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * User row tests.
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

class Neatline_NeatlineUserTest extends NWS_Test_AppTestCase
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
     * _validateRegistration() should throw errors for missing fields.
     *
     * @return void.
     */
    public function testValidateRegistrationEmptyFields()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with empty fields.
        $errors = $user->_validateRegistration(
            '',
            '',
            '',
            '');

        // Check for the errors.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_absent'),
            $errors['username']
        );

        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'password_absent'),
            $errors['password']
        );

        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'email_absent'),
            $errors['email']
        );

    }

    /**
     * _validateRegistration() should throw an error if there is already
     * a user with the supplied username.
     *
     * @return void.
     */
    public function testValidateRegistrationUsernameTaken()
    {

        // Create a user.
        $user1 = $this->__user();
        $user2 = new NeatlineUser;

        // Register with taken name.
        $errors = $user2->_validateRegistration(
            'username',
            '',
            '',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_taken'),
            $errors['username']
        );

    }

    /**
     * _validateRegistration() should throw an error if the username is
     * too long.
     *
     * @return void.
     */
    public function testValidateRegistrationUsernameTooLong()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            'itlittleprofitsthatanidlekingbythisstillhearth',
            '',
            '',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_too_long'),
            $errors['username']
        );

    }

    /**
     * _validateRegistration() should throw an error if the username is not
     * alphanumeric.
     *
     * @return void.
     */
    public function testValidateRegistrationUsernameNotAlnum()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with spaces in username.
        $errors = $user->_validateRegistration(
            'user with spaces',
            '',
            '',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_alnum'),
            $errors['username']
        );

        // Register with spaces in username.
        $errors = $user->_validateRegistration(
            'userwithillegalchar!',
            '',
            '',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'username_alnum'),
            $errors['username']
        );

    }

    /**
     * _validateRegistration() should throw an error if the submitted email
     * address is not valid.
     *
     * @return void.
     */
    public function testValidateRegistrationInvalidEmail()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with invalid address.
        $errors = $user->_validateRegistration(
            '',
            '',
            '',
            'invalid');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'email_invalid'),
            $errors['email']
        );

    }

    /**
     * _validateRegistration() should throw an error if there is already a
     * user with the supplied email.
     *
     * @return void.
     */
    public function testValidateRegistrationEmailTaken()
    {

        // Create two users.
        $user1 = $this->__user('test1', 'test1', 'test1@test.edu');
        $user2 = new NeatlineUser;

        // Register taken address.
        $errors = $user2->_validateRegistration(
            '',
            '',
            '',
            'test1@test.edu');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'email_taken'),
            $errors['email']
        );

    }

    /**
     * _validateRegistration() should throw an error if the password is
     * too short.
     *
     * @return void.
     */
    public function testValidateRegistrationPasswordTooShort()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            '',
            'x',
            '',
            '');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'password_too_short'),
            $errors['password']
        );

    }

    /**
     * _validateRegistration() should throw an error for a missing password
     * confirmation.
     *
     * @return void.
     */
    public function testValidateRegistrationEmptyPasswordConfirm()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with missing confirmation.
        $errors = $user->_validateRegistration(
            '',
            'password',
            '',
            '');

        // Check for the errors.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'password_confirm_absent'),
            $errors['confirm']
        );

    }

    /**
     * _validateRegistration() should throw an error when the password and
     * confirmation do not match.
     *
     * @return void.
     */
    public function testValidateRegistrationPasswordConfirmationMismatch()
    {

        // Create a user.
        $user = $this->__user();
        $user = new NeatlineUser;

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            'username',
            'password',
            'incorrect',
            'test@virginia.edu');

        // Check for the error.
        $this->assertEquals(
            $errors['confirm'],
            get_plugin_ini('NeatlineWebService', 'password_confirm_mismatch')
        );

    }

    /**
     * _validateRegistration() should return an empty array when the submission
     * is valid.
     *
     * @return void.
     */
    public function testValidateRegistrationSuccess()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with valid credentials.
        $errors = $user->_validateRegistration(
            'username',
            'password',
            'password',
            'test@virginia.edu');

        // Check for empty array.
        $this->assertEquals($errors, array());
        $this->assertEquals(count($errors), 0);

    }

    /**
     * _applyRegistration() should set values and generate password hash/salt.
     *
     * @return void.
     */
    public function testApplyRegistration()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with valid credentials.
        $errors = $user->_applyRegistration(
            'username',
            'password',
            'test@virginia.edu');

        // Check record.
        $this->assertEquals($user->username, 'username');
        $this->assertEquals($user->email, 'test@virginia.edu');
        $this->assertNotNull($user->password);
        $this->assertNotNull($user->salt);
        $this->assertTrue($user->checkPassword('password'));

    }

    /**
     * checkPassword() should return false when the password is incorrect.
     *
     * @return void.
     */
    public function testCheckPasswordWithIncorrectPassword()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with valid credentials.
        $errors = $user->_applyRegistration(
            'username',
            'password',
            'test@virginia.edu');

        $user->save();

        // Check.
        $this->assertFalse($user->checkPassword('incorrect'));

    }

    /**
     * checkPassword() should return true when the password is correct.
     *
     * @return void.
     */
    public function testCheckPasswordWithCorrectPassword()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Register with valid credentials.
        $errors = $user->_applyRegistration(
            'username',
            'password',
            'test@virginia.edu');

        $user->save();

        // Check.
        $this->assertTrue($user->checkPassword('password'));

    }

    /**
     * getRoleId() should return the class constant ROLE.
     *
     * @return void.
     */
    public function testGetRoleId()
    {

        // Create a user.
        $user = new NeatlineUser;

        // Check.
        $this->assertEquals($user->getRoleId(), NeatlineUser::ROLE);

    }

}
