<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Authorization adapter.
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

class NeatlineAuthAdapter implements Zend_Auth_Adapter_Interface
{

    protected $_username;
    protected $_password;

    /**
     * Set credentials and get database.
     *
     * @return void
     */
    public function __construct($username, $password)
    {

        $this->_username = $username;
        $this->_password = $password;

    }

    /**
     * Perform authentication attempt.
     *
     * @return Zend_Auth_Result.
     */
    public function authenticate()
    {

        // // Get the users table.
        // $_usersTable = $this->getTable('NeatlineUser');

        // // Try to find a record by username.
        // $user = $_usersTable->findBySql('username = ' . $this->_username);

        // // Non-existent user.
        // if (is_null($user)) {
        //     return new Zend_Auth_Result(
        //         Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
        //         $this->_username
        //     );
        // }

        // // Valid user.
        // else if ($user->checkPassword($this->_password)) {
        //     return new Zend_Auth_Result(
        //         Zend_Auth_Result::SUCCESS
        //     );
        // }

        // // Wrong password.
        // else {
        //     return new Zend_Auth_Result(
        //         Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
        //         $this->_username
        //     );
        // }

    }

}
