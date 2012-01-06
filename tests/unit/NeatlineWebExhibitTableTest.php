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
        $exhibit = new NeatlineWebExhibit($user1);
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
     * getExhibitsByUser() should return exhibits belonging to the passed user.
     *
     * @return void.
     */
    public function testGetExhibitsByUser()
    {

        // Create 2 users.
        $user1 = $this->__user($username = 'user1');
        $user2 = $this->__user($username = 'user2');

        $exhibit1 = new NeatlineWebExhibit($user1);
        $exhibit1->slug =    'test1';
        $exhibit1->public =  1;
        $exhibit1->save();

        $exhibit2 = new NeatlineWebExhibit($user1);
        $exhibit2->slug =    'test2';
        $exhibit2->public =  1;
        $exhibit2->save();

        $exhibit3 = new NeatlineWebExhibit($user1);
        $exhibit3->slug =    'test3';
        $exhibit3->public =  1;
        $exhibit3->save();

        $exhibit4 = new NeatlineWebExhibit($user1);
        $exhibit4->slug =    'test4';
        $exhibit4->public =  1;
        $exhibit4->save();

        $exhibit5 = new NeatlineWebExhibit($user2);
        $exhibit5->slug =    'test5';
        $exhibit5->public =  1;
        $exhibit5->save();

        $exhibit6 = new NeatlineWebExhibit($user2);
        $exhibit6->slug =    'test6';
        $exhibit6->public =  1;
        $exhibit6->save();

        // Get.
        $exhibits = $this->_exhibitsTable->getExhibitsByUser($user1);

        // Count.
        $this->assertEquals(count($exhibits), 4);

        // Get.
        $exhibits = $this->_exhibitsTable->getExhibitsByUser($user2);

        // Count.
        $this->assertEquals(count($exhibits), 2);

    }

}
