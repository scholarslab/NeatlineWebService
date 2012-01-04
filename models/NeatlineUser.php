<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * User row class.
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

class NeatlineUser extends Omeka_record
{


    /**
     * Record attributes.
     */

    public $username;
    public $password;
    public $salt;
    public $email;


    /**
     * Validation constants.
     */

    CONST USERNAME_MAX_LENGTH = 30;
    CONST PASSWORD_MIN_LENGTH = 6;


    /**
     * Validate registration.
     *
     * @param string $username  Username.
     * @param string $password  Password.
     * @param string $confirm   Password confirmation.
     * @param string $email     Email.
     *
     * @return array $errors    The array of errors.
     */
    public function _validateRegistration(
        $username,
        $password,
        $confirm,
        $email
    )
    {

        // Errors array.
        $errors = array();

        // Validators.
        $emailValidator = new Zend_Validate_EmailAddress();
        $alnumValidator = new Zend_Validate_Alnum();

        /**
         * USERNAME
         */

        if ($username == '') {
            $errors['username'] = get_plugin_ini(
                'NeatlineWebService',
                'username_absent'
            );
        }

        else if (!$this->getTable('NeatlineUser')
            ->usernameIsAvailable($username)) {
                $errors['username'] = get_plugin_ini(
                    'NeatlineWebService',
                    'username_taken'
                );
        }

        else if (strlen($username) > self::USERNAME_MAX_LENGTH) {
            $errors['username'] = get_plugin_ini(
                'NeatlineWebService',
                'username_too_long'
            );
        }

        else if (!$alnumValidator->isValid($username)) {
            $errors['username'] = get_plugin_ini(
                'NeatlineWebService',
                'username_alnum'
            );
        }

        /**
         * PASSWORD
         */

        if ($password == '') {
            $errors['password'] = get_plugin_ini(
                'NeatlineWebService',
                'password_absent'
            );
        }

        else if (strlen($password) < self::PASSWORD_MIN_LENGTH) {
            $errors['password'] = get_plugin_ini(
                'NeatlineWebService',
                'password_too_short'
            );
        }

        /**
         * PASSWORD CONFIRM
         */

        else {

            if ($confirm == '') {
                $errors['confirm'] = get_plugin_ini(
                    'NeatlineWebService',
                    'password_confirm_absent'
                );
            }

            else if ($confirm != $password) {
                $errors['confirm'] = get_plugin_ini(
                    'NeatlineWebService',
                    'password_confirm_mismatch'
                );
            }

        }

        /**
         * EMAIL
         */

        if ($email == '') {
            $errors['email'] = get_plugin_ini(
                'NeatlineWebService',
                'email_absent'
            );
        }

        else if (!$emailValidator->isValid($email)) {
                $errors['email'] = get_plugin_ini(
                    'NeatlineWebService',
                    'email_invalid'
                );
        }

        else if (!$this->getTable('NeatlineUser')
            ->emailIsAvailable($email)) {
                $errors['email'] = get_plugin_ini(
                    'NeatlineWebService',
                    'email_taken'
                );
        }

        return $errors;

    }


    /**
     * Apply registration parameters.
     *
     * @param string $username  Username.
     * @param string $password  Password.
     * @param string $email     Email.
     *
     * @return array $errors    The array of errors.
     */
    public function _applyRegistration(
        $username,
        $password,
        $email
    )
    {

        // Set raw.
        $this->username =   $username;
        $this->email =      $email;

        // Set password.
        $this->setPassword($password);


    }

    /**
     * Generate salt for password.
     *
     * @return void.
     */
    public function generateSalt()
    {
        $this->salt = substr(md5(mt_rand()), 0, 16);
    }

    /**
     * Hash password.
     *
     * @param string $password  Password.
     *
     * @return string           The hash.
     */
    public function hashPassword($password)
    {
        return sha1($this->salt . $password);
    }

    /**
     * Set password.
     *
     * @param string $password  Password.
     *
     * @return void.
     */
    public function setPassword($password)
    {

        if ($this->salt === null) {
            $this->generateSalt();
        }

        $this->password = $this->hashPassword($password);

    }

    /**
     * Check password.
     *
     * @param string $password  Password.
     *
     * @return True if the password is correct.
     */
    public function checkPassword($password)
    {

        return $this->hashPassword($password) == $this->password;

    }

}
