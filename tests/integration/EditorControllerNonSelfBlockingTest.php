<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Editor controller non-self blocking tests.
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

class NeatlineWebService_EditorControllerNonSelfBlockingTest extends NWS_Test_AppTestCase
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

        // Create user two users.
        $this->user1 = $this->__user(
            $username = 'user1',
            $password = 'password',
            $email = 'email1@test.com');
        $this->user2 = $this->__user(
            $username = 'user2',
            $password = 'password',
            $email = 'email2@test.com');

        // Authenticate user1.
        $adapter = new NeatlineAuthAdapter('user1', 'password');
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));
        $auth->authenticate($adapter);

        // Create an exhibit for user2.
        $this->exhibit = $this->__exhibit(
            $this->user2,
            'Test',
            'test-slug',
            true
        );

    }

    /**
     * /
     *
     * @return void.
     */
    public function testBlockIndex()
    {
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/test-slug');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /items
     *
     * @return void.
     */
    public function testBlockItems()
    {
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/items');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /form
     *
     * @return void.
     */
    public function testBlockForm()
    {
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/form');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /save
     *
     * @return void.
     */
    public function testBlockSave()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/save');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /status
     *
     * @return void.
     */
    public function testBlockStatus()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/status');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /order
     *
     * @return void.
     */
    public function testBlockOrder()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/order');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /positions
     *
     * @return void.
     */
    public function testBlockPositions()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/positions');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /arrangement
     *
     * @return void.
     */
    public function testBlockArrangement()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/arrangement');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /focus
     *
     * @return void.
     */
    public function testBlockFocus()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/focus');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /mapsettings
     *
     * @return void.
     */
    public function testBlockMapsettings()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/mapsettings');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /add
     *
     * @return void.
     */
    public function testBlockAdd()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/add');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /resetstyles
     *
     * @return void.
     */
    public function testBlockResetstyles()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/resetstyles');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

    /**
     * /delete
     *
     * @return void.
     */
    public function testBlockDelete()
    {
        $this->request->setMethod('POST');
        $this->dispatch(NLWS_SLUG . 'admin/user2/editor/ajax/delete');
        $this->assertRedirectTo(nlws_url('exhibits'));
    }

}
