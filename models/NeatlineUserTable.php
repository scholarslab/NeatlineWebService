<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

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

}
