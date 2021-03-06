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
            true,
            'Test description.'
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
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

        // Check for the form.
        $this->assertQuery('div.title input[value="Test"]');
        $this->assertQuery('div.slug input[value="test-slug"]');
        $this->assertQuery('div.public input[checked="checked"]');
        $this->assertQueryContentContains('div.description textarea', 'Test description.');

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
                'description' => ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

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
        $exhibit = $this->__exhibit($this->user, 'Test Title', 'taken-slug', 1);

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>   '',
                'slug' =>   'taken-slug',
                'description' => ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

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
                'slug' =>   '',
                'description' => ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

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
                'slug' =>   'test-title',
                'description' => ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

        // Check for the value.
        $this->assertQuery('div.slug input[value="test-title"]');

    }

    /**
     * /edit should persist a description on form re-display.
     *
     * @return void.
     */
    public function testDescriptionSlugPersistence()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  '',
                'slug' =>   'test-title',
                'description' => 'Test description.'
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

        // Check for the value.
        $this->assertQueryContentContains('div.description textarea', 'Test description.');

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
                'public' => 'on',
                'description' => ''
            )
        );

        // Hit the route.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');

        // Check for the value.
        $this->assertQuery('div.public input[checked="checked"]');

    }

    /**
     * When a slug is saved that is the same as another users's slug, /edit
     * should allow the commit.
     *
     * @return void.
     */
    public function testEditWithSlugMatchingDifferentUsersSlug()
    {

        // Create a second user.
        $user2 = $this->__user(
            'username2',
            'password2',
            'test2@test.com'
        );

        // Create a second exhibit.
        $exhibit = $this->__exhibit(
            $user2,
            'Test2',
            'different-slug',
            true
        );

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'New Title',
                'slug' =>   'different-slug',
                'description' => ''
            )
        );

        // Hit the route, check for redirect.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // Check for updated values.
        // $updatedExhibit = $this->_webExhibitsTable->find($this->exhibit->id);
        $parentExhibit = $this->exhibit->getExhibit();
        $this->assertEquals($parentExhibit->name, 'New Title');
        $this->assertEquals($parentExhibit->slug, 'different-slug');
        $this->assertEquals($parentExhibit->public, 0);

    }

    /**
     * When the slug is unchanged, /edit should not flag the slug as taken.
     *
     * @return void.
     */
    public function testEditWithUnchangedSlug()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'title' =>  'New Title',
                'slug' =>   'test-slug',
                'description' => ''
            )
        );

        // Hit the route, check for redirect.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // Check for updated values.
        $parentExhibit = $this->exhibit->getExhibit();
        $this->assertEquals($parentExhibit->name, 'New Title');
        $this->assertEquals($parentExhibit->slug, 'test-slug');
        $this->assertEquals($parentExhibit->public, 0);

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
                'description' => 'New description.'
            )
        );

        // Hit the route, check for redirect.
        $this->dispatch(NLWS_SLUG . 'nl-admin/username/edit/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));

        // Check for updated values.
        $parentExhibit = $this->exhibit->getExhibit();
        $this->assertEquals($parentExhibit->name, 'New Title');
        $this->assertEquals($parentExhibit->slug, 'new-slug');
        $this->assertEquals($parentExhibit->description, 'New description.');
        $this->assertEquals($parentExhibit->public, 0);



    }

}
