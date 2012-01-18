<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * SaaS facade for the Neatline editor controller. Adds preDispatch authorization
 * to each of the actions.
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

class NeatlineWebService_EditorController extends Neatline_EditorController
{

    /**
     * Block any requests from not-logged-in users.
     *
     * @return void
     */
    public function preDispatch()
    {

        // Get the authentication singleton, activate the NLWS storage.
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('Neatline'));

        // Check for identity.
        $hasIdentity = $auth->hasIdentity();

        // If not logged in, block.
        if (!$hasIdentity) {
            return $this->_redirect(NLWS_SLUG);
        }

        else {

            $this->user = $auth->getIdentity();

        }

    }

    /**
     * Run the editor application.
     *
     * @return void
     */
    public function indexAction()
    {

        // Get the web exhibits table.
        $_webExhibitsTable =        $this->getTable('NeatlineWebExhibit');
        $_layersTable =             $this->getTable('NeatlineBaseLayer');

        // Get records and shell out defaults.
        $slug =                     $this->_request->getParam('slug');
        $webExhibit =               $_webExhibitsTable->findBySlug($slug, $this->user);
        $exhibit =                  $webExhibit->getExhibit();
        $layers =                   $_layersTable->findAll();

        // Construct the data array for the exhibit.
        $neatlineData = array(
            'public' =>             false,
            'neatline' =>           $exhibit,
            'dataSources' => array(
                'timeline' =>       neatline_getTimelineDataUrl($exhibit->id),
                'map' =>            neatline_getMapDataUrl($exhibit->id),
                'undated' =>        neatline_getUndatedItemsDataUrl($exhibit->id)
            )
        );

        // Push records.
        $this->view->neatline =     $exhibit;
        $this->view->neatlineData = $neatlineData;
        $this->view->map =          $map;
        $this->view->layers =       $layers;

    }

}
