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

        // Get the web exhibits and layers tables.
        $this->_webExhibitsTable =  $this->getTable('NeatlineWebExhibit');
        $this->_layersTable =       $this->getTable('NeatlineBaseLayer');

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

            // Push identity into actions
            $this->user = $auth->getIdentity();

            // Get the route.
            $routeName = Zend_Controller_Front
                ::getInstance()
                ->getRouter()
                ->getCurrentRouteName();

            // If the route is an ajax request.
            if ($routeName == 'nlwsEditorAction') {

                // Get exhibit id.
                $exhibitId = (int) $this->_request->getParam('exhibit_id');

                // Block non-owners.
                if (!$this->_webExhibitsTable->userOwnsExhibit($this->user, $exhibitId)) {
                    return $this->_redirect(nlws_url('exhibits'));
                }

            }

        }

    }

    /**
     * Run the editor application.
     *
     * @return void
     */
    public function indexAction()
    {

        // Get records.
        $slug =                     $this->_request->getParam('slug');
        $webExhibit =               $this->_webExhibitsTable->findBySlug($slug, $this->user);

        // Block non-owner access.
        if ($this->user->username != $this->_request->getParam('user')) {
            return $this->_redirect(nlws_url('exhibits'));
        }

        // Get Neatline exhibit and base layers.
        $exhibit =                  $webExhibit->getExhibit();
        $layers =                   $this->_layersTable->findAll();

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
