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

        // Roll up the environment.
        parent::setUp();
        $this->setUpPlugin();

        // Get the database and table.
        $this->db = get_db();
        $this->_usersTable = $this->db->getTable('NeatlineUser');

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

        // Register with mismatching confirmation.
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

        // Create a user, set username.
        $user = $this->__user($username = 'david');

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            'david',
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
     * _validateRegistration() should throw an error if the submitted email
     * address is not valid.
     *
     * @return void.
     */
    public function testValidateRegistrationInvalidEmail()
    {

        // Create a user, set username.
        $user = new NeatlineUser;

        // Register with mismatching confirmation.
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

        // Create a user, set username.
        $user = $this->__user($email = 'dwm@uva.edu');

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            '',
            '',
            '',
            'dwm@uva.edu');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'email_taken'),
            $errors['email']
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

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            '',
            'poesypure',
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
        $user = new NeatlineUser;

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            'davidmcclure',
            'poesypure',
            'poesyimpure',
            'dwm@uva.edu');

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

        // Register with mismatching confirmation.
        $errors = $user->_validateRegistration(
            'davidmcclure',
            'poesypure',
            'poesypure',
            'dwm@uva.edu');

        // Check for empty array.
        $this->assertEquals($errors, array());
        $this->assertEquals(count($errors), 0);

    }

}
