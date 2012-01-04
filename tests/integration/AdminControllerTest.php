<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admininistration controller integration tests.
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

class NeatlineWebService_AdminControllerTest extends NWS_Test_AppTestCase
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
     * /register should render the registration form.
     *
     * @return void.
     */
    public function testRegisterFormDisplay()
    {

        // Hit the route.
        $this->dispatch('webservice/register');

        // Check for the form.
        $this->assertQuery('input[name="username"]');
        $this->assertQuery('input[name="password"]');
        $this->assertQuery('input[name="confirm"]');
        $this->assertQuery('input[name="email"]');

    }

    /**
     * /register should render errors for submission with empty fields.
     *
     * @return void.
     */
    public function testRegisterErrorsEmptyFields()
    {

        // Prepare the request.
        $this->request->setMethod('POST')
            ->setPost(array(
                'username' =>   '',
                'password' =>   '',
                'confirm' =>    '',
                'email' =>      ''
            )
        );

        // Hit the route.
        $this->dispatch('webservice/register');

        // Check for the error classes.
        $this->assertQuery('div.error input[name="username"]');
        $this->assertQuery('div.error input[name="password"]');
        $this->assertQuery('div.error input[name="email"]');

        // Check for the errors.
        $this->assertQueryContentContains(
            'div.username span.help-inline',
            get_plugin_ini('NeatlineWebService', 'username_absent')
        );

        $this->assertQueryContentContains(
            'div.password span.help-inline',
            get_plugin_ini('NeatlineWebService', 'password_absent')
        );

        $this->assertQueryContentContains(
            'div.email span.help-inline',
            get_plugin_ini('NeatlineWebService', 'email_absent')
        );

    }

}
