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

        // Roll up the environment.
        parent::setUp();
        $this->setUpPlugin();

        // Get the database and table.
        $this->db = get_db();
        $this->_usersTable = $this->db->getTable('NeatlineUser');

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
     * nlws_editUrl() should construct a well-formed edit url.
     *
     * @return void.
     */
    public function testEditUrl()
    {

        // Create user.
        $user = $this->__user($username = 'david');

        // Create NLW exhibit and parent exhibit.
        $exhibit = $this->__exhibit($user = $user);
        $exhibit->slug = 'test-slug';

        $this->assertEquals(
            nlws_editUrl($exhibit),
            WEB_ROOT . '/' . NLWS_SLUG . '/david/editor/test-slug'
        );

    }

}
