<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests for the edit flow.
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

class NeatlineWebService_AdminControllerDeleteTest extends NWS_Test_AppTestCase
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

        // Create a user.
        $this->user = $this->__user(
            'username',
            'password',
            'test@test.com'
        );

        // Authenticate.
        $adapter = new NeatlineAuthAdapter('username', 'password');
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));
        $auth->authenticate($adapter);

        // Create an exhibit.
        $this->exhibit = $this->__exhibit(
            $this->user,
            'Test',
            'test-slug',
            true
        );

    }

    /**
     * /delete render the delete form.
     *
     * @return void.
     */
    public function testDeleteFormDisplay()
    {

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/username/delete/test-slug');

        // Check for the form and exhibit title.
        $this->assertQuery('form#delete-form button[type="submit"]');

    }

    /**
     * /delete should delete the exhibit when there is a post.
     *
     * @return void.
     */
    public function testDeleteSuccess()
    {

        // Create a second exhibit.
        $exhibit2 = $this->__exhibit(
            $this->user,
            'Test2',
            'another-slug',
            true
        );

        // Starting count.
        $webExhibitsCount = $this->_webExhibitsTable->count();
        $nealineExhibitsCount = $this->_exhibitsTable->count();

        // Hit the route.
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . '/username/delete/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // Web exhibit deleted.
        $this->assertEquals(
            $this->_webExhibitsTable->count(),
            $webExhibitsCount - 1
        );

        // Neatline exhibit deleted.
        $this->assertEquals(
            $this->_exhibitsTable->count(),
            $nealineExhibitsCount - 1
        );

        // Check that the right exhibit was deleted.
        $remainingExhibit = $this->_webExhibitsTable->find($exhibit2->id);
        $this->assertNotNull($remainingExhibit);

    }

}
