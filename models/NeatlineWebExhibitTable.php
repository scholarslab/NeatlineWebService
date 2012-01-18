<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Web exhibit table class.
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

class NeatlineWebExhibitTable extends Omeka_Db_Table
{

    /**
     * Find an exhibit by its slug.
     *
     * @param string $slug          The slug.
     * @param Omeka_record $user    The user.
     *
     * @return Omeka_records        The exhibit.
     */
    public function findBySlug($slug, $user)
    {

        // Prepare the select.
        $select = $this->getSelect()->where(
            'slug = "' . $slug . '" AND user_id = ' . $user->id
        );

        // Query.
        $result = $this->fetchObject($select);

        return $result ? $result : false;

    }

    /**
     * Check to see if the supplied slug is available for a given user.
     *
     * @param Omeka_record user     The user.
     * @param string $slug          The slug.
     *
     * @return boolean True if the slug is available.
     */
    public function slugIsAvailable($user, $slug)
    {

        // Prepare the select.
        $select = $this->getSelect()->where(
            'slug = "' . $slug . '" AND user_id = ' . $user->id
        );

        // Query.
        $result = $this->fetchObject($select);

        return is_null($result);

    }

    /**
     * Get exhibits by user.
     *
     * @param Omeka_record user     The user.
     *
     * @return array of Omeka_record objects.
     */
    public function getExhibitsByUser($user)
    {

        // Prepare the select.
        $select = $this->getSelect()->where(
            'user_id = ' . $user->id
        );

        // Query.
        return $this->fetchObjects($select);

    }

    /**
     * Check whether a user is the owner of a web exhibit that is the
     * facade of a Neatline native exhibit with a given id.
     *
     * @param Omeka_record user     The user.
     * @param integer exhibit_id    The Neatline exhibit id.
     *
     * @return boolean True if the user owns the exhibit.
     */
    public function userOwnsExhibit($user, $exhibit_id)
    {



    }

}
