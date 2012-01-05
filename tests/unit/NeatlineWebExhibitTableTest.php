<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Web exhibit table tests.
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

class Neatline_NeatlineWebExhibitTableTest extends NWS_Test_AppTestCase
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
        $this->_exhibitsTable = $this->db->getTable('NeatlineWebExhibit');

    }

    /**
     * slugIsAvailable() should return true or false depending on whether or not
     * there is an existing exhibit with the supplied slug.
     *
     * @return void.
     */
    public function testSlugIsAvailable()
    {

        // Create 2 users.
        $user1 = $this->__user($username = 'user1');
        $user2 = $this->__user($username = 'user2');

        // Create NLW exhibit for user1.
        $exhibit = new NeatlineWebExhibit;
        $exhibit->user_id = $user1->id;
        $exhibit->slug = 'taken-slug';
        $exhibit->public = 1;
        $exhibit->save();

        // False when user1 is passed.
        $this->assertFalse(
            $this->_exhibitsTable->slugIsAvailable($user1, 'taken-slug')
        );

        // False when user2 is passed.
        $this->assertTrue(
            $this->_exhibitsTable->slugIsAvailable($user2, 'taken-slug')
        );

    }

    /**
     * _validate() should throw errors for missing fields.
     *
     * @return void.
     */
    public function testValidateEmptyFields()
    {

        // Create a user.
        $user = $this->__user();

        // Validate with empty fields.
        $errors = $this->_exhibitsTable->_validate(
            $user,
            '',
            '');

        // Check for the errors.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'title_absent'),
            $errors['title']
        );

        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'slug_absent'),
            $errors['slug']
        );

    }

    /**
     * _validate() should throw errors for a duplicate slug.
     *
     * @return void.
     */
    public function testValidateDuplicateSlug()
    {

        // Create 2 users.
        $user1 = $this->__user($username = 'user1');
        $user2 = $this->__user($username = 'user2');

        // Create NLW exhibit for user1.
        $exhibit = new NeatlineWebExhibit;
        $exhibit->user_id = $user1->id;
        $exhibit->slug = 'taken-slug';
        $exhibit->public = 1;
        $exhibit->save();

        // Validate with slug for user1.
        $errors = $this->_exhibitsTable->_validate(
            $user1,
            '',
            'taken-slug');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'slug_taken'),
            $errors['slug']
        );

        // Validate with slug for user1.
        $errors = $this->_exhibitsTable->_validate(
            $user2,
            '',
            'taken-slug');

        // No errors.
        $this->assertFalse(array_key_exists('slug', $errors));

    }

}
