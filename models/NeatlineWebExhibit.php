<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Web exhibit row class.
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

class NeatlineWebExhibit extends Omeka_Record
{


    /**
     * Record attributes.
     */

    public $user_id;
    public $exhibit_id;


    /**
     * Create the parallel Neatline exhibit.
     *
     * @param Omeka_record $user    The parent user.
     *
     * @return void.
     */
    public function __construct($user)
    {

        parent::__construct();

        // Set the user key.
        $this->user_id = $user->id;

    }

    /**
     * Create a parent Neatline exhibit.
     *
     * @param string $title: Title.
     * @param string $slug: Slug.
     * @param boolean $public: Public.
     * @param string $description: Description.
     *
     * @return void.
     */
    public function createParentExhibit($title, $slug, $public, $description)
    {

        // Create Neatline exhibit.
        $exhibit = new NeatlineExhibit;
        $exhibit->name =            $title;
        $exhibit->description =     $description;
        $exhibit->slug =            $slug;
        $exhibit->public =          $public ? 1 : 0;
        $exhibit->top_element =     'map';
        $exhibit->items_h_pos =     'right';
        $exhibit->items_v_pos =     'bottom';
        $exhibit->items_height =    'full';
        $exhibit->is_map =          1;
        $exhibit->is_timeline =     1;
        $exhibit->is_items =        1;
        $exhibit->is_context_band = 1;
        $exhibit->save();

        // Set the exhibit key.
        $this->exhibit_id = $exhibit->id;

    }

    /**
     * Retrieve the parent user record.
     *
     * @return Omeka_record         The user.
     */
    public function getUser()
    {
        $_usersTable = $this->getTable('NeatlineUser');
        return $_usersTable->find($this->user_id);
    }

    /**
     * Retrieve the parent exhibit record.
     *
     * @return Omeka_record         The exhibit.
     */
    public function getExhibit()
    {
        $_exhibitsTable = $this->getTable('NeatlineExhibit');
        return $_exhibitsTable->find($this->exhibit_id);
    }

    /**
     * Validate new exhibit.
     *
     * @param string $title         The title.
     * @param string $slug          The slug.
     *
     * @return array $errors    The array of errors.
     */
    public function _validateAdd($title, $slug)
    {

        // Errors array and exhibits table.
        $errors = array();
        $_exhibitsTable = $this->getTable('NeatlineWebExhibit');

        /**
         * TITLE
         */

        // If no title.
        if ($title == '') {
            $errors['title'] = get_plugin_ini(
                'NeatlineWebService',
                'title_absent'
            );
        }

        /**
         * SLUG
         */

        // If no slug.
        if ($slug == '') {
            $errors['slug'] = get_plugin_ini(
                'NeatlineWebService',
                'slug_absent'
            );
        }

        // Duplicate slug.
        else if (
            !$_exhibitsTable->slugIsAvailable($this->getUser(), $slug) &&
            $slug != $this->slug
        ) {

            $errors['slug'] = get_plugin_ini(
                'NeatlineWebService',
                'slug_taken'
            );

        }

        // Invalid slug.
        else if (!preg_match('/^[0-9a-z\-]+$/', $slug)) {
            $errors['slug'] = get_plugin_ini(
                'NeatlineWebService',
                'slug_invalid'
            );
        }

        return $errors;

    }

    /**
     * Set values.
     *
     * @param string $title         The title.
     * @param string $slug          The slug.
     * @param boolean $public       Public or private.
     * @param string $description   The description.
     *
     * @return void.
     */
    public function _apply($title, $slug, $public, $description)
    {

        // Set the parent exhibit attributes.
        $parentExhibit = $this->getExhibit();
        $parentExhibit->name =        $title;
        $parentExhibit->description = $description;
        $parentExhibit->slug =        strtolower($slug);
        $parentExhibit->public =      $public ? 1 : 0;
        $parentExhibit->save();

    }

    /**
     * Get the number of active records for the exhibit.
     *
     * @return integer              The record count.
     */
    public function getNumberOfRecords()
    {
        return $this->getExhibit()->getNumberOfRecords();
    }

    /**
     * Delete the parent exhibit.
     *
     * @return void.
     */
    public function beforeDelete()
    {
        $this->getExhibit()->delete();
    }

}
