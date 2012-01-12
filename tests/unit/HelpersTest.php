<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Unit tests for helper functions.
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

class Neatline_NeatlineHelpersTest extends NWS_Test_AppTestCase
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
     * nlws_getErrorClass() should return the error class if there is an error
     * for a key, empty string if there is not an error.
     *
     * @return void.
     */
    public function testGetErrorClassWithErrors()
    {

        // Errors array.
        $errors = array(
            'username' =>   'error',
            'password' =>   'error',
            'confirm' =>    'error',
            'email' =>      'error'
        );

        // Test for error class.
        $this->assertEquals(
            'error',
            nlws_getErrorClass($errors, 'username', 'error')
        );

        $this->assertEquals(
            'error',
            nlws_getErrorClass($errors, 'password', 'error')
        );

        $this->assertEquals(
            'error',
            nlws_getErrorClass($errors, 'confirm', 'error')
        );

        $this->assertEquals(
            'error',
            nlws_getErrorClass($errors, 'email', 'error')
        );

    }

    /**
     * nlws_getErrorClass() should return the error class if there is an error
     * for a key, empty string if there is not an error.
     *
     * @return void.
     */
    public function testGetErrorClassWithoutErrors()
    {

        // Errors array.
        $errors = array();

        // Test for blank string.
        $this->assertEquals(
            '',
            nlws_getErrorClass($errors, 'username', 'error')
        );

        $this->assertEquals(
            '',
            nlws_getErrorClass($errors, 'password', 'error')
        );

        $this->assertEquals(
            '',
            nlws_getErrorClass($errors, 'confirm', 'error')
        );

        $this->assertEquals(
            '',
            nlws_getErrorClass($errors, 'email', 'error')
        );

    }

    /**
     * nlws_url() should construct correct routes based on the passed parameters.
     *
     * @return void.
     */
    public function testNlwsUrl()
    {

        // Create a user.
        $this->__user();

        // Authenticate.
        $adapter = new NeatlineAuthAdapter('username', 'password');
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));
        $auth->authenticate($adapter);

        // Context-dependent constants.
        $common = WEB_ROOT . '/' . NLWS_SLUG;

        // When just username is passed.
        $this->assertEquals(
            nlws_url(),
            $common . '/username'
        );

        // When a username and action are passed.
        $this->assertEquals(
            nlws_url('edit'),
            $common . '/username/edit'
        );

        // When a username, action, and slug are passed.
        $this->assertEquals(
            nlws_url('edit', 'test-slug'),
            $common . '/username/edit/test-slug'
        );

    }

}
