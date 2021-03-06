<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * User table class.
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

class NeatlineUserTable extends Omeka_Db_Table
{

    /**
     * Check to see if the supplied username is available.
     *
     * @param string $username  Username.
     *
     * @return boolean True if the name is available.
     */
    public function usernameIsAvailable($username)
    {

        // Query for user.
        $user = $this->findBySql('username = ?', array($username));

        return count($user) == 0;

    }

    /**
     * Check to see if the supplied email is available.
     *
     * @param string $email     Email.
     *
     * @return boolean True if the address is available.
     */
    public function emailIsAvailable($email)
    {

        // Query for user.
        $user = $this->findBySql('email = ?', array($email));

        return count($user) == 0;

    }

    /**
     * Retrieve a user record by username
     *
     * @param string $username Username.
     *
     * @return Omeka_record     The record, if one exists, false if
     * there is no user with the supplied name.
     */
    public function findByUsername($username)
    {

        // Prepare the select and query.
        $select = $this->getSelect()->where('username = ?', $username);
        $result = $this->fetchObject($select);

        return !is_null($result) ? $result : false;

    }

    /**
     * Validate login.
     *
     * @param string $username  Username.
     * @param string $password  Password.
     *
     * @return array $errors    The array of errors.
     */
    public function _validateLogin($username, $password)
    {

        // Errors array.
        $errors = array();

        /**
         * USERNAME
         */

        // If no username.
        if ($username == '') {
            $errors['username'] = get_plugin_ini(
                'NeatlineWebService',
                'username_absent'
            );
        } else {

            // Try to get the user.
            $user = $this->findByUsername($username);

            // If no user.
            if (!$user) {
                $errors['username'] = get_plugin_ini(
                    'NeatlineWebService',
                    'username_does_not_exist'
                );
            } else if ($password == '') {
                /**
                 * PASSWORD
                 */

                // If no password.

                $errors['password'] = get_plugin_ini(
                    'NeatlineWebService',
                    'password_absent'
                );
            } else if (!$user->checkPassword($password)) {
// If user exists, check password.
                $errors['password'] = get_plugin_ini(
                    'NeatlineWebService',
                    'password_incorrect'
                );
            }

        }

        return $errors;

    }

}
