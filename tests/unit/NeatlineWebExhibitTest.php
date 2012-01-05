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
     * __construct() should automatically create a new Neatline exhibit.
     *
     * @return void.
     */
    public function testCreateNewNeatlineExhibit()
    {

        // Starting NL exhibit count.
        $count = $this->_exhibitsTable->count();

        // Create NLW exhibit.
        $exhibit = new NeatlineWebExhibit;

        // +1.
        $this->assertEquals($this->_exhibitsTable->count(), $count + 1);

        // Check for set exhibit_id.
        $this->assertNotNull($exhibit->exhibit_id);

    }

}
