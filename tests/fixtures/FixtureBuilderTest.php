<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Special 'test' suite that hits each of the routes in the fixtures controller
 * and saves off the baked markup. Ensures that the front end test suite is always
 * working on real-application HTML.
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
 * @author      Bethany Nowviskie <bethany@virginia.edu>
 * @author      Adam Soroka <ajs6f@virginia.edu>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2011 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */

class NeatlineWebService_FixtureBuilderTest extends NWS_Test_AppTestCase
{

    private static $path_to_fixtures = '../spec/javascripts/fixtures/';

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

        // Create a user.
        $this->user = $this->__user(
            $username = 'david',
            $password = 'poesypure'
        );

        // Authenticate.
        $adapter = new NeatlineAuthAdapter('david', 'poesypure');
        $auth = Zend_Auth::getInstance();
        $auth->authenticate($adapter);

    }

    /**
     * Base Neatline exhibit markup.
     *
     * @return void.
     */
    public function testBuildNeatlineMarkup()
    {

        $fixture = fopen(self::$path_to_fixtures . 'add-form.html', 'w');

        $this->dispatch('neatline-web-service/fixtures/add-form');
        $response = $this->getResponse()->getBody('default');

        fwrite($fixture, $response);
        fclose($fixture);

    }

}
