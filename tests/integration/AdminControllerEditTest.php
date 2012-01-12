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

class NeatlineWebService_AdminControllerEditTest extends NWS_Test_AppTestCase
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
     * /edit should render the edit form.
     *
     * @return void.
     */
    public function testEditFormDisplay()
    {

        // Hit the route.
        $this->dispatch('neatline/username/edit/test-slug');

        // Check for the form.
        $this->assertQuery('div.title input[value="Test"]');
        $this->assertQuery('div.slug input[value="test-slug"]');
        $this->assertQuery('div.public input[checked="checked"]');

    }

    /**
     * /edit should render errors for submission with empty fields.
     *
     * @return void.
     */
    public function testEditErrorsEmptyFields()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>   '',
                'slug' =>   '',
            )
        );

        // Hit the route.
        $this->dispatch('neatline/username/edit/test-slug');

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

    }

    /**
     * /edit should render error for a reserved slug.
     *
     * @return void.
     */
    public function testEditErrorsSlugTaken()
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
        $this->dispatch('neatline/username/edit/test-slug');

        // Check for the error class.
        $this->assertQuery('div.error input[name="slug"]');

        // Check for the error.
        $this->assertQueryContentContains(
            'div.slug span.help-inline',
            get_plugin_ini('NeatlineWebService', 'slug_taken')
        );

    }

    /**
     * /edit should persist a title on form re-display.
     *
     * @return void.
     */
    public function testEditTitlePersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'Title',
                'slug' =>   ''
            )
        );

        // Hit the route.
        $this->dispatch('neatline/username/edit/test-slug');

        // Check for the value.
        $this->assertQuery('div.title input[value="Title"]');

    }

    /**
     * /edit should persist a slug on form re-display.
     *
     * @return void.
     */
    public function testEditSlugPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  '',
                'slug' =>   'test-title'
            )
        );

        // Hit the route.
        $this->dispatch('neatline/username/edit/test-slug');

        // Check for the value.
        $this->assertQuery('div.slug input[value="test-title"]');

    }

    /**
     * /edit should persist a public setting on form re-display.
     *
     * @return void.
     */
    public function testEditPublicPersistence()
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
        $this->dispatch('neatline/username/edit/test-slug');

        // Check for the value.
        $this->assertQuery('div.public input[checked="checked"]');

    }

    /**
     * With valid parameters, /edit should save changes.
     *
     * @return void.
     */
    public function testEditSuccess()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'New Title',
                'slug' =>   'new-slug',
                'public' => 'off'
            )
        );

        // Hit the route, check for redirect.
        $this->dispatch('neatline/username/edit/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));

    }

}
