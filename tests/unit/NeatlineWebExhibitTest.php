<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Web exhibit row tests.
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

class Neatline_NeatlineWebExhibitTest extends NWS_Test_AppTestCase
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

        // Get the database and tables.
        $this->db = get_db();
        $this->_exhibitsTable = $this->db->getTable('NeatlineExhibit');
        $this->_webExhibitsTable = $this->db->getTable('NeatlineWebExhibit');

    }

    /**
     * __construct() should automatically create a new Neatline exhibit and set
     * foreign keys for user and exhibit.
     *
     * @return void.
     */
    public function testCreateNewNeatlineExhibit()
    {

        // Create a user.
        $user = $this->__user();

        // Starting NL exhibit count.
        $count = $this->_exhibitsTable->count();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);

        // +1.
        $this->assertEquals($this->_exhibitsTable->count(), $count + 1);

        // Get the new exhibit.
        $newExhibit = $this->__getMostRecentNeatlineExhibit();

        // Check for exhibit_id key.
        $this->assertEquals(
            $exhibit->exhibit_id,
            $newExhibit->id
        );

        // Check for user_id key.
        $this->assertEquals(
            $exhibit->user_id,
            $user->id
        );

    }

    /**
     * getUser() should return the parent user object.
     *
     * @return void.
     */
    public function testGetUser()
    {

        // Create a user and exhibit.
        $user =     $this->__user();
        $exhibit    = $this->__exhibit($user = $user);

        // Get out the user.
        $retrievedUser = $exhibit->getUser();

        // Check identity.
        $this->assertEquals($user->id, $retrievedUser->id);

    }

    /**
     * getExhibit() should return the parent exhibit object.
     *
     * @return void.
     */
    public function testGetExhibit()
    {

        // Create an exhibit.
        $exhibit    = $this->__exhibit();

        // Get out the exhibit.
        $exhibit = $exhibit->getExhibit();

        // Get the new exhibit.
        $newExhibit = $this->__getMostRecentNeatlineExhibit();

        // Check identity.
        $this->assertEquals($exhibit->id, $newExhibit->id);

    }

    /**
     * _validate() should throw errors for missing fields.
     *
     * @return void.
     */
    public function testValidateEmptyFields()
    {

        // Create a user and exhibit.
        $user =     $this->__user();
        $exhibit    = $this->__exhibit($user = $user);

        // Validate with empty fields.
        $errors = $exhibit->_validateAdd(
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
        $exhibit1 = new NeatlineWebExhibit($user1);
        $exhibit1->slug = 'taken-slug';
        $exhibit1->public = 1;
        $exhibit1->save();

        // Create NLW exhibit for user2.
        $exhibit2 = new NeatlineWebExhibit($user1);
        $exhibit3 = new NeatlineWebExhibit($user2);

        // Validate with slug for user1.
        $errors = $exhibit2->_validateAdd(
            '',
            'taken-slug');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'slug_taken'),
            $errors['slug']
        );

        // Validate with slug for user1.
        $errors = $exhibit3->_validateAdd(
            '',
            'taken-slug');

        // No errors.
        $this->assertFalse(array_key_exists('slug', $errors));

    }

    /**
     * _validate() should throw errors for a slug with spaces.
     *
     * @return void.
     */
    public function testValidateSlugWithSpaces()
    {

        // Create an exhibit.
        $exhibit    = $this->__exhibit();

        // Validate with empty fields.
        $errors = $exhibit->_validateAdd(
            '',
            'slug with spaces');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'slug_invalid'),
            $errors['slug']
        );

    }

    /**
     * _validate() should throw errors for a slug with non-alphanumeric
     * characters.
     *
     * @return void.
     */
    public function testValidateSlugWithNonAlphanumbericCharacters()
    {

        // Create an exhibit.
        $exhibit    = $this->__exhibit();

        // Validate with empty fields.
        $errors = $exhibit->_validateAdd(
            '',
            'slug-with-non-alphanumerics!');

        // Check for the error.
        $this->assertEquals(
            get_plugin_ini('NeatlineWebService', 'slug_invalid'),
            $errors['slug']
        );

    }

    /**
     * _validate() should not throw an error when all of the characters in
     * the slug are '-' or alphanumerics.
     *
     * @return void.
     */
    public function testValidateSlugWithAlphanumerics()
    {

        // Create an exhibit.
        $exhibit    = $this->__exhibit();

        // Validate with empty fields.
        $errors = $exhibit->_validateAdd(
            '',
            'test-exhibit-2012');

        // Check for the error.
        $this->assertArrayNotHasKey(
            'slug',
            $errors
        );

    }

    /**
     * _applyAdd() should assign column values.
     *
     * @return void.
     */
    public function testApplyAdd()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);

        // Apply.
        $exhibit->_applyAdd('Test Title', 'test-title', true);

        // Get the new exhibit.
        $newExhibit = $exhibit->getExhibit();

        // Check.
        $this->assertEquals($newExhibit->name, 'Test Title');
        $this->assertEquals($exhibit->slug, 'test-title');
        $this->assertEquals($exhibit->public, 1);

    }

    /**
     * _applyAdd() should lowercase the slug.
     *
     * @return void.
     */
    public function testApplyAddLowercaseSlug()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);

        // Apply.
        $exhibit->_applyAdd('Test Title', 'Test-Title', true);

        // Get the new exhibit.
        $newExhibit = $exhibit->getExhibit();

        // Check.
        $this->assertEquals($newExhibit->name, 'Test Title');
        $this->assertEquals($exhibit->slug, 'test-title');
        $this->assertEquals($exhibit->public, 1);

    }

}
