<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

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

class NeatlineWebExhibit extends Omeka_record
{


    /**
     * Record attributes.
     */

    public $user_id;
    public $exhibit_id;
    public $slug;
    public $public;


    /**
     * Create the parallel Neatline exhibit.
     *
     * @return void.
     */
    public function __construct()
    {

        parent::__construct();

        // Create Neatline exhibit.
        $exhibit = new NeatlineExhibit;
        $exhibit->top_element =            'map';
        $exhibit->items_h_pos =            'right';
        $exhibit->items_v_pos =            'bottom';
        $exhibit->items_height =           'full';
        $exhibit->is_map =                 1;
        $exhibit->is_timeline =            1;
        $exhibit->is_items =               1;
        $exhibit->save();

        // Set the exhibit foreign key.
        $this->exhibit_id = $exhibit->id;

    }


}
