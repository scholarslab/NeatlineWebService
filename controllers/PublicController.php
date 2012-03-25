<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Public exhibit views.
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

class NeatlineWebService_PublicController extends Omeka_Controller_Action
{

    /**
     * Native-environment public exhibit view.
     *
     * @return void
     */
    public function showAction()
    {

        // Get the web exhibits table.
        $_webExhibitsTable =    $this->getTable('NeatlineWebExhibit');
        $_usersTable =          $this->getTable('NeatlineUser');

        // Get records and shell out defaults.
        $slug =                     $this->_request->getParam('slug');
        $username =                 $this->_request->getParam('user');
        $user =                     $_usersTable->findByUsername($username);
        $webExhibit =               $_webExhibitsTable->findBySlug($slug, $user);
        $exhibit =                  $webExhibit->getExhibit();

        // Push records.
        $this->view->public =       (bool) $webExhibit->public;
        $this->view->exhibit =      $exhibit;

    }

    /**
     * Embedded public exhibit view.
     *
     * @return void
     */
    public function embedAction()
    {

        // Get the web exhibits table.
        $_webExhibitsTable =    $this->getTable('NeatlineWebExhibit');
        $_usersTable =          $this->getTable('NeatlineUser');

        // Get records and shell out defaults.
        $slug =                     $this->_request->getParam('slug');
        $username =                 $this->_request->getParam('user');
        $user =                     $_usersTable->findByUsername($username);
        $webExhibit =               $_webExhibitsTable->findBySlug($slug, $user);
        $exhibit =                  $webExhibit->getExhibit();

        // Push records.
        $this->view->public =       (bool) $webExhibit->public;
        $this->view->exhibit =      $exhibit;

    }

}
