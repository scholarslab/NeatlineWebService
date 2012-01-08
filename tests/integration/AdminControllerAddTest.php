<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests for the add flow.
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

class NeatlineWebService_AdminControllerAddTest extends NWS_Test_AppTestCase
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

        // Create a user, authenticate.
        $this->user = $this->__user($username = 'david', $password = 'poesypure');
        $adapter = new NeatlineAuthAdapter('david', 'poesypure');
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));
        $auth->authenticate($adapter);

    }

    /**
     * /add should render the registration form.
     *
     * @return void.
     */
    public function testRegisterFormDisplay()
    {

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the form.
        $this->assertQuery('input[name="title"]');
        $this->assertQuery('input[name="slug"]');
        $this->assertQuery('input[name="public"]');

    }

    /**
     * /add should render errors for submission with empty fields.
     *
     * @return void.
     */
    public function testAddErrorsEmptyFields()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>   '',
                'slug' =>   '',
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the error classes.
        $this->assertQuery('div.error input[name="title"]');
        $this->assertQuery('div.error input[name="slug"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.title span.help-inline',
            get_plugin_ini('NeatlineWebService', 'title_absent')
        );

        $this->assertQueryContentContains(
            'div.slug span.help-inline',
            get_plugin_ini('NeatlineWebService', 'slug_absent')
        );

        // No exhibit created.
        $this->assertEquals($this->_exhibitsTable->count(), 0);

    }

    /**
     * /add should render error for a reserved slug.
     *
     * @return void.
     */
    public function testAddErrorsSlugTaken()
    {

        // Create NLW exhibit for the user.
        $exhibit = new NeatlineWebExhibit($this->user);
        $exhibit->slug = 'taken-slug';
        $exhibit->public = 1;
        $exhibit->save();

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>   '',
                'slug' =>   'taken-slug'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the error class.
        $this->assertQuery('div.error input[name="slug"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.slug span.help-inline',
            get_plugin_ini('NeatlineWebService', 'slug_taken')
        );

        // No exhibit created.
        $this->assertEquals($this->_exhibitsTable->count(), 1);

    }

    /**
     * /add should persist a title on form re-display.
     *
     * @return void.
     */
    public function testAddTitlePersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'Title',
                'slug' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the value.
        $this->assertQuery('div.title input[value="Title"]');

    }

    /**
     * /add should persist a slug on form re-display.
     *
     * @return void.
     */
    public function testAddSlugPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  '',
                'slug' =>   'test-title'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the value.
        $this->assertQuery('div.slug input[value="test-title"]');

    }

    /**
     * /add should persist a public setting on form re-display.
     *
     * @return void.
     */
    public function testAddPublicPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  '',
                'slug' =>   '',
                'public' => 'on'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . '/add');

        // Check for the value.
        $this->assertQuery('div.public input[checked="checked"]');

    }

    /**
     * With valid parameters, /add should create a new exhibit and redirect
     * to /exhibits.
     *
     * @return void.
     */
    public function testAddSuccess()
    {

        // Create a second user.
        $user2 = $this->__user();

        // Create NLW exhibit for user2.
        $exhibit = new NeatlineWebExhibit($user2);
        $exhibit->slug = 'taken-slug';
        $exhibit->public = 1;
        $exhibit->save();

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'Test Title',
                'slug' =>   'new-slug',
                'public' => 'on'
            )
        );

        // Hit the route, check for redirect.
        $this->dispatch(NLWS_SLUG . '/add');
        $this->assertRedirectTo('/' . NLWS_SLUG . '/exhibits');

        // No exhibit created.
        $this->assertEquals($this->_exhibitsTable->count(), 2);

    }

}
