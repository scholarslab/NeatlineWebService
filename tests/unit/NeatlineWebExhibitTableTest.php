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

        parent::setUp();
        $this->setUpPlugin();

    }

    /**
     * findBySlug() should return false when there is no exhibit with the passed slug.
     *
     * @return void.
     */
    public function testFindBySlugWhenExhibitDoesNotExist()
    {

        // Create user two users.
        $user1 = $this->__user(
            $username = 'user1',
            $password = 'password',
            $email = 'email1@test.com');
        $user2 = $this->__user(
            $username = 'user2',
            $password = 'password',
            $email = 'email2@test.com');

        // Create NLW exhibits.
        $exhibit1 = $this->__exhibit($user1, 'Test Title 1', 'existing-slug', 1);
        $exhibit2 = $this->__exhibit($user2, 'Test Title 2', 'another-slug', 1);

        // False for non-existent slug.
        $this->assertFalse(
            $this->_webExhibitsTable->findBySlug('unused-slug', $user1)
        );

        // False for slug reserved by another user's exhibit.
        $this->assertFalse(
            $this->_webExhibitsTable->findBySlug('another-slug', $user1)
        );

    }

    /**
     * findBySlug() should return false when there is no exhibit with the passed slug.
     *
     * @return void.
     */
    public function testFindBySlugWhenExhibitExists()
    {

        // Create user two users.
        $user1 = $this->__user(
            $username = 'user1',
            $password = 'password',
            $email = 'email1@test.com');
        $user2 = $this->__user(
            $username = 'user2',
            $password = 'password',
            $email = 'email2@test.com');

        // Create NLW exhibits.
        $exhibit1 = $this->__exhibit($user1, 'Test Title 1', 'same-slug', 1);
        $exhibit2 = $this->__exhibit($user2, 'Test Title 2', 'same-slug', 1);

        // Get out the exhibits.
        $user1Exhibit = $this->_webExhibitsTable->findBySlug('same-slug', $user1);
        $user2Exhibit = $this->_webExhibitsTable->findBySlug('same-slug', $user2);

        // Check 1.
        $this->assertEquals(
            $exhibit1->id, $user1Exhibit->id
        );

        // Check 2.
        $this->assertEquals(
            $exhibit2->id, $user2Exhibit->id
        );

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
        $user1 = $this->__user('test1', 'test1', 'test1@virginia.edu');
        $user2 = $this->__user('test2', 'test2', 'test2@virginia.edu');

        // Create NLW exhibit for user1.
        $exhibit = $this->__exhibit($user1, 'Test Title', 'taken-slug', 1);

        // False when user1 is passed.
        $this->assertFalse(
            $this->_webExhibitsTable->slugIsAvailable($user1, 'taken-slug')
        );

        // True when user2 is passed.
        $this->assertTrue(
            $this->_webExhibitsTable->slugIsAvailable($user2, 'taken-slug')
        );

    }

    /**
     * getExhibitsByUser() should return exhibits belonging to the passed user.
     *
     * @return void.
     */
    public function testGetExhibitsByUser()
    {

        // Create 2 users.
        $user1 = $this->__user('test1', 'test1', 'test1@virginia.edu');
        $user2 = $this->__user('test2', 'test2', 'test2@virginia.edu');

        $exhibit1 = new NeatlineWebExhibit($user1);
        $exhibit1->slug =    'test1';
        $exhibit1->public =  1;
        $exhibit1->createParentExhibit();
        $exhibit1->save();

        $exhibit2 = new NeatlineWebExhibit($user1);
        $exhibit2->slug =    'test2';
        $exhibit2->public =  1;
        $exhibit2->createParentExhibit();
        $exhibit2->save();

        $exhibit3 = new NeatlineWebExhibit($user1);
        $exhibit3->slug =    'test3';
        $exhibit3->public =  1;
        $exhibit3->createParentExhibit();
        $exhibit3->save();

        $exhibit4 = new NeatlineWebExhibit($user1);
        $exhibit4->slug =    'test4';
        $exhibit4->public =  1;
        $exhibit4->createParentExhibit();
        $exhibit4->save();

        $exhibit5 = new NeatlineWebExhibit($user2);
        $exhibit5->slug =    'test5';
        $exhibit5->public =  1;
        $exhibit5->createParentExhibit();
        $exhibit5->save();

        $exhibit6 = new NeatlineWebExhibit($user2);
        $exhibit6->slug =    'test6';
        $exhibit6->public =  1;
        $exhibit6->createParentExhibit();
        $exhibit6->save();

        // Get.
        $exhibits = $this->_webExhibitsTable->getExhibitsByUser($user1);

        // Count.
        $this->assertEquals(count($exhibits), 4);

        // Get.
        $exhibits = $this->_webExhibitsTable->getExhibitsByUser($user2);

        // Count.
        $this->assertEquals(count($exhibits), 2);

    }

    /**
     * getExhibitsByUserSortedByModified() should return exhibits belonging
     * to the passed user, joined with the exhibit table and ordered by 'modified'.
     *
     * @return void.
     */
    public function testGetExhibitsByUserSortedByModified()
    {

        // Create 2 users.
        $user1 = $this->__user('test1', 'test1', 'test1@virginia.edu');
        $user2 = $this->__user('test2', 'test2', 'test2@virginia.edu');

        $exhibit1 = new NeatlineWebExhibit($user1);
        $exhibit1->slug =    'test1';
        $exhibit1->public =  1;
        $exhibit1->createParentExhibit();
        $exhibit1->save();

        $exhibit2 = new NeatlineWebExhibit($user1);
        $exhibit2->slug =    'test2';
        $exhibit2->public =  1;
        $exhibit2->createParentExhibit();
        $exhibit2->save();

        $exhibit3 = new NeatlineWebExhibit($user1);
        $exhibit3->slug =    'test3';
        $exhibit3->public =  1;
        $exhibit3->createParentExhibit();
        $exhibit3->save();

        $exhibit4 = new NeatlineWebExhibit($user1);
        $exhibit4->slug =    'test4';
        $exhibit4->public =  1;
        $exhibit4->createParentExhibit();
        $exhibit4->save();

        $exhibit5 = new NeatlineWebExhibit($user2);
        $exhibit5->slug =    'test5';
        $exhibit5->public =  1;
        $exhibit5->createParentExhibit();
        $exhibit5->save();

        $exhibit6 = new NeatlineWebExhibit($user2);
        $exhibit6->slug =    'test6';
        $exhibit6->public =  1;
        $exhibit6->createParentExhibit();
        $exhibit6->save();

        // Get parent exhibits.
        $parent1 = $exhibit1->getExhibit();
        $parent2 = $exhibit2->getExhibit();
        $parent3 = $exhibit3->getExhibit();
        $parent4 = $exhibit4->getExhibit();
        $parent5 = $exhibit5->getExhibit();
        $parent6 = $exhibit6->getExhibit();

        // Set modifications.
        $parent2->modified = '2012-01-05 00:00:00';
        $parent2->parentSave();
        $parent1->modified = '2012-01-04 05:00:00';
        $parent1->parentSave();
        $parent4->modified = '2012-01-04 04:00:00';
        $parent4->parentSave();
        $parent3->modified = '2012-01-03 00:00:00';
        $parent3->parentSave();
        $parent5->modified = '2012-01-02 00:00:00';
        $parent5->parentSave();
        $parent6->modified = '2012-01-01 00:00:00';
        $parent6->parentSave();

        // Get.
        $exhibits = $this->_webExhibitsTable->getExhibitsByUserSortedByModified($user1);

        // Check order.
        $this->assertEquals($exhibits[0]->id, $exhibit2->id);
        $this->assertEquals($exhibits[1]->id, $exhibit1->id);
        $this->assertEquals($exhibits[2]->id, $exhibit4->id);
        $this->assertEquals($exhibits[3]->id, $exhibit3->id);

        // Get.
        $exhibits = $this->_webExhibitsTable->getExhibitsByUserSortedByModified($user2);

        // Check order.
        $this->assertEquals($exhibits[0]->id, $exhibit5->id);
        $this->assertEquals($exhibits[1]->id, $exhibit6->id);

    }

    /**
     * userOwnsExhibit() should return false if the user does not own
     * the Neatline exhibit with the passed id.
     *
     * @return void.
     */
    public function testUserOwnsExhibit()
    {

        // Create.
        $user1 = $this->__user('test1', 'test', 'test1@virginia.edu');
        $user2 = $this->__user('test2', 'test', 'test2@virginia.edu');

        $exhibit1 = new NeatlineWebExhibit($user1);
        $exhibit1->slug =    'test1';
        $exhibit1->public =  1;
        $exhibit1->createParentExhibit();
        $exhibit1->save();

        $exhibit2 = new NeatlineWebExhibit($user1);
        $exhibit2->slug =    'test2';
        $exhibit2->public =  1;
        $exhibit2->createParentExhibit();
        $exhibit2->save();

        $exhibit3 = new NeatlineWebExhibit($user1);
        $exhibit3->slug =    'test3';
        $exhibit3->public =  1;
        $exhibit3->createParentExhibit();
        $exhibit3->save();

        $exhibit4 = new NeatlineWebExhibit($user2);
        $exhibit4->slug =    'test4';
        $exhibit4->public =  1;
        $exhibit4->createParentExhibit();
        $exhibit4->save();

        // True when owner.
        $this->assertTrue($this->_webExhibitsTable->userOwnsExhibit(
            $user1,
            $exhibit1->getExhibit()->id));
        $this->assertTrue($this->_webExhibitsTable->userOwnsExhibit(
            $user1,
            $exhibit2->getExhibit()->id));
        $this->assertTrue($this->_webExhibitsTable->userOwnsExhibit(
            $user1,
            $exhibit3->getExhibit()->id));
        $this->assertTrue($this->_webExhibitsTable->userOwnsExhibit(
            $user2,
            $exhibit4->getExhibit()->id));

        // False when not owner.
        $this->assertFalse($this->_webExhibitsTable->userOwnsExhibit(
            $user2,
            $exhibit1->getExhibit()->id));
        $this->assertFalse($this->_webExhibitsTable->userOwnsExhibit(
            $user2,
            $exhibit2->getExhibit()->id));
        $this->assertFalse($this->_webExhibitsTable->userOwnsExhibit(
            $user2,
            $exhibit3->getExhibit()->id));
        $this->assertFalse($this->_webExhibitsTable->userOwnsExhibit(
            $user1,
            $exhibit4->getExhibit()->id));


    }

}
