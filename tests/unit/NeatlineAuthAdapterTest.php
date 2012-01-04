<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Unit tests for the authentication adapter.
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

class Neatline_NeatlineAuthAdapterTest extends NWS_Test_AppTestCase
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

    }

    /**
     * When a non-existent username is passed, the adapter should return an
     * FAILURE_IDENTITY_NOT_FOUND response.
     *
     * @return void.
     */
    public function testIdentityNotFound()
    {


    }

    /**
     * When an existing username is passed with an incorrect password, the
     * adapter should return an FAILURE_CREDENTIAL_INVALID response.
     *
     * @return void.
     */
    public function testInvalidCredential()
    {


    }

    /**
     * When a valid username/password combination is passed, the adapter
     * should return a SUCCESS response.
     *
     * @return void.
     */
    public function testSuccess()
    {


    }



}
