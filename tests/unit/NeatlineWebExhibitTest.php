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

        parent::setUp();
        $this->setUpPlugin();

    }

    /**
     * __construct() should automatically set the user foreign key.
     *
     * @return void.
     */
    public function testCreateNewNeatlineExhibit()
    {

        // Create a user.
        $user = $this->__user();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);

        // Check for user_id key.
        $this->assertEquals(
            $exhibit->user_id,
            $user->id
        );

    }

    /**
     * createParentExhibit() should create a parent Neatline exhibit.
     *
     * @return void.
     */
    public function testCreateParentExhibit()
    {

        // Create a user.
        $user = $this->__user();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);

        // Starting NL exhibit count.
        $count = $this->_exhibitsTable->count();

        // Create.
        $exhibit->createParentExhibit();

        // +1.
        $this->assertEquals($this->_exhibitsTable->count(), $count + 1);

        // Get the new exhibit.
        $newExhibit = $this->__getMostRecentNeatlineExhibit();

        // Check for exhibit_id key.
        $this->assertEquals(
            $exhibit->exhibit_id,
            $newExhibit->id
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
        $exhibit =  $this->__exhibit($user);

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
        $webExhibit = $this->__exhibit();
        $neatlineExhibit = $webExhibit->getExhibit();

        // Get the new exhibit.
        $newExhibit = $this->__getMostRecentNeatlineExhibit();

        // Check identity.
        $this->assertEquals($neatlineExhibit->id, $newExhibit->id);

    }

    /**
     * _validate() should throw errors for missing fields.
     *
     * @return void.
     */
    public function testValidateEmptyFields()
    {

        // Create a user and exhibit.
        $user = $this->__user();
        $exhibit = $this->__exhibit($user);

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
        $user1 = $this->__user('test1', 'test1', 'test1@virginia.edu');
        $user2 = $this->__user('test2', 'test2', 'test2@virginia.edu');

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
        $exhibit = $this->__exhibit();

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
        $exhibit = $this->__exhibit();

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
        $exhibit = $this->__exhibit();

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
     * _apply() should assign column values.
     *
     * @return void.
     */
    public function testApply()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit and parent exhibit.
        $exhibit = new NeatlineWebExhibit($user);
        $exhibit->createParentExhibit();

        // Apply.
        $exhibit->_apply('Test Title', 'test-title', true);

        // Get the new exhibit.
        $newExhibit = $exhibit->getExhibit();

        // Check.
        $this->assertEquals($newExhibit->name, 'Test Title');
        $this->assertEquals($exhibit->slug, 'test-title');
        $this->assertEquals($exhibit->public, 1);

    }

    /**
     * _apply() should lowercase the slug.
     *
     * @return void.
     */
    public function testApplyLowercaseSlug()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit and parent exhibit.
        $exhibit = new NeatlineWebExhibit($user);
        $exhibit->createParentExhibit();

        // Apply.
        $exhibit->_apply('Test Title', 'Test-Title', true);

        // Get the new exhibit.
        $newExhibit = $exhibit->getExhibit();

        // Check.
        $this->assertEquals($newExhibit->name, 'Test Title');
        $this->assertEquals($exhibit->slug, 'test-title');
        $this->assertEquals($exhibit->public, 1);

    }

    /**
     * getNumberOfItems() should return 0 when there are no items.
     *
     * @return void.
     */
    public function testGetNumberOfItemsWithNoRecords()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit($user);
        $exhibit->createParentExhibit();

        // Check.
        $this->assertEquals($exhibit->getNumberOfRecords(), 0);

    }

    /**
     * getNumberOfItems() should return the number of records.
     *
     * @return void.
     */
    public function testGetNumberOfItemsWithRecords()
    {

        // Create user.
        $user = $this->__user();

        // Create NLW exhibit, get parent exhibit.
        $exhibit1 = new NeatlineWebExhibit($user);
        $exhibit2 = new NeatlineWebExhibit($user);
        $exhibit1->createParentExhibit();
        $exhibit2->createParentExhibit();
        $parentExhibit1 = $exhibit1->getExhibit();
        $parentExhibit2 = $exhibit2->getExhibit();

        // Create records.
        $record1 = new NeatlineDataRecord(null, $parentExhibit1);
        $record2 = new NeatlineDataRecord(null, $parentExhibit1);
        $record3 = new NeatlineDataRecord(null, $parentExhibit2);
        $record4 = new NeatlineDataRecord(null, $parentExhibit2);
        $record1->space_active = 1;
        $record2->space_active = 1;
        $record3->space_active = 1;
        $record4->space_active = 0;
        $record1->save();
        $record2->save();
        $record3->save();
        $record4->save();

        // Check.
        $this->assertEquals($exhibit1->getNumberOfRecords(), 2);
        $this->assertEquals($exhibit2->getNumberOfRecords(), 1);

    }

}
