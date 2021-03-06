/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/*
 * Runner for add form.
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

jQuery(document).ready(function($) {

    // Get markup.
    var addForm = $('#add-form');
    var description = $('textarea[name="description"]');

    // Run the slug previewer.
    addForm.slugBuilder({
        web_root: NeatlineWebService.web_root
    });

    // Text editor on description.
    description.redactor();

});
