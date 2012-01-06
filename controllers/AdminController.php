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
     * Actions that require authentication.
     */
    private static $_protectedActions = array(
        'exhibits',
        'add',
        'delete',
        'edit'
    );

    /**
     * Actions that do not require authentication.
     */
    private static $_anonActions = array(
        'register',
        'login'
    );


    /**
     * Get models.
     *
     * @return void
     */
    public function init()
    {
        $this->_usersTable =    $this->getTable('NeatlineUser');
        $this->_exhibitsTable = $this->getTable('NeatlineWebExhibit');
    }

    /**
     * Authentication routing.
     *
     * @return void
     */
    public function preDispatch()
    {

        // Get the controller action.
        $action =           $this->getRequest()->getActionName();
        $hasIdentity =      Zend_Auth::getInstance()->hasIdentity();

        // If not logged in and requesting protected action, block.
        if (!$hasIdentity && in_array($action, self::$_protectedActions)) {
            return $this->_redirect('webservice/login');
        }

        // If logged in.
        else if ($hasIdentity) {

            // Push the user object.
            $this->view->user = Zend_Auth::getInstance()->getIdentity();

            // If requesting an anonymous action, redirect to browse.
            if (in_array($action, self::$_anonActions)) {
                return $this->_redirect('webservice/exhibits');
            }

        }

    }


    /**
     * View actions.
     */


    /**
     * Registration.
     *
     * @return void
     */
    public function registerAction()
    {

        $user =                 new NeatlineUser;
        $errors =               array();
        $username =             '';
        $password =             '';
        $confirm =              '';
        $email =                '';

        // Process submission.
        if ($this->_request->isPost()) {

            // Gather $_POST.
            $_post =            $this->_request->getPost();
            $username =         $_post['username'];
            $password =         $_post['password'];
            $confirm =          $_post['confirm'];
            $email =            $_post['email'];

            // Register the credentials, capture errors.
            $errors = $user->_validateRegistration(
                $username,
                $password,
                $confirm,
                $email
            );

            // If no errors, save and redirect.
            if (count($errors) == 0) {

                // Set columns.
                $user->_applyRegistration(
                    $username,
                    $password,
                    $email
                );

                // Commit.
                $user->save();

                // Authenticate the new user.
                $adapter =      $this->getAuthAdapter($username, $password);
                $auth =         Zend_Auth::getInstance();
                $result =       $auth->authenticate($adapter);

                // Redirect to root.
                return $this->_redirect('webservice/exhibits');

            }

        }

        // Push user and errors.
        $this->view->user =         $user;
        $this->view->errors =       $errors;
        $this->view->username =     $username;
        $this->view->password =     $password;
        $this->view->confirm =      $confirm;
        $this->view->email =        $email;

    }

    /**
     * Login.
     *
     * @return void
     */
    public function loginAction()
    {

        $errors =               array();
        $username =             '';
        $password =             '';

        // Process submission.
        if ($this->_request->isPost()) {

            // Gather $_POST.
            $_post =            $this->_request->getPost();
            $username =         $_post['username'];
            $password =         $_post['password'];

            // Register the credentials, capture errors.
            $errors = $this->_usersTable->_validateLogin(
                $username,
                $password
            );

            // If no errors, save and redirect.
            if (count($errors) == 0) {

                // Authenticate the new user.
                $adapter =      $this->getAuthAdapter($username, $password);
                $auth =         Zend_Auth::getInstance();
                $result =       $auth->authenticate($adapter);

                // Redirect to root.
                return $this->_redirect('webservice/exhibits');

            }

        }

        // Push errors.
        $this->view->errors =       $errors;
        $this->view->username =     $username;
        $this->view->password =     $password;

    }

    /**
     * Logout.
     *
     * @return void
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_redirect('webservice/login');
    }

    /**
     * Reset password.
     *
     * @return void
     */
    public function passwordAction()
    {

    }

    /**
     * Browse exhibits.
     *
     * @return void
     */
    public function exhibitsAction()
    {

    }

    /**
     * Create exhibit.
     *
     * @return void
     */
    public function addAction()
    {

        $exhibit =              new NeatlineWebExhibit($this->view->user);
        $errors =               array();
        $title =                '';
        $slug =                 '';

        // Process submission.
        if ($this->_request->isPost()) {

            // Gather $_POST.
            $_post =            $this->_request->getPost();
            $title =            $_post['title'];
            $slug =             $_post['slug'];
            $public =           array_key_exists('public', $_post);

            // Register the credentials, capture errors.
            $errors = $exhibit->_validateAdd($title, $slug);

            // If no errors, save and redirect.
            if (count($errors) == 0) {

                // Set columns.
                $exhibit->_applyAdd($title, $slug, $public);

                // Commit.
                $exhibit->save();

                // Redirect to root.
                return $this->_redirect('webservice/exhibits');

            }

        }

        // Push errors.
        $this->view->errors =       $errors;
        $this->view->title =        $title;
        $this->view->slug =         $slug;

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


    /**
     * Authentication.
     */


    /**
     * Construct the session adapter.
     *
     * @param string $username      Username.
     * @param string $password      Password.
     *
     * @return void
     */
    private function getAuthAdapter($username, $password)
    {
        return new NeatlineAuthAdapter($username, $password);
    }


}
