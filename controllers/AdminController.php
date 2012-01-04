<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Administrative functionality.
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
?>

<?php

class NeatlineWebService_AdminController extends Omeka_Controller_Action
{

    /**
     * Get models.
     *
     * @return void
     */
    public function init()
    {
        $this->_usersTable = $this->getTable('User');
    }

    /**
     * Registration.
     *
     * @return void
     */
    public function registerAction()
    {

        $user = new NeatlineUser;
        $errors = array();

        // Process submission.
        if ($this->_request->isPost()) {

            // Gather $_POST.
            $_post =                $this->_request->getPost();
            $username =             $_post['username'];
            $password =             $_post['password'];
            $confirm =              $_post['confirm'];
            $email =                $_post['email'];

            // Register the credentials, capture errors.
            $errors = $user->_validateRegistration(
                $username,
                $password,
                $confirm,
                $email
            );

            // If no errors, save and redirect.
            if (count($errors) == 0) {
                $user->save();
                return $this->_redirect('webservice');
            }

        }

        // Push user and errors.
        $this->view->user =         $user;
        $this->view->errors =       $errors;

    }

    /**
     * Login.
     *
     * @return void
     */
    public function loginAction()
    {

    }

    /**
     * Logout.
     *
     * @return void
     */
    public function logoutAction()
    {

    }

    /**
     * Browse exhibits.
     *
     * @return void
     */
    public function browseAction()
    {

    }

    /**
     * Create exhibit.
     *
     * @return void
     */
    public function addAction()
    {

    }

    /**
     * Edit exhibit.
     *
     * @return void
     */
    public function editAction()
    {

    }

    /**
     * Delete exhibit.
     *
     * @return void
     */
    public function deleteAction()
    {

    }

}
