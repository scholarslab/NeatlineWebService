/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/*
 * Controls the slug auto-generation/recommendation in the /add view.
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

(function($, undefined) {


    $.widget('neatlinewebservice.slugBuilder', {

        options: {

        },

        /*
         * .
         *
         * - return void.
         */
        _create: function() {

            // Get markup.
            this._body =        $('body');
            this._window =      $(window);
            this.title =        $('div.title input');
            this.slug =         $('div.slug input');
            this.preview =      $('#url-slug-preview');

            // Trackers.
            this._hasTyped = false;

            // Bind listeners.
            this._addEvents();

        },

        /*
         * .
         *
         * - return void.
         */
        _addEvents: function() {

            var self = this;

            this.title.bind({

                'keyup': function() {

                }

            });

            this.slug.bind({

                'keydown': function(e) {

                    // Replace spaces with '-'.
                    if (e.keyCode == 32) {

                        e.preventDefault();

                        var val = self.slug.val();
                        self.slug.val(val + '-');
                        self.slug.trigger('keyup');

                    }

                },

                'keyup': function() {
                    self.setPreview(self.slug.val());
                }

            });

        },


        /*
         * =================
         * DOM touches.
         * =================
         */


        /*
         * Render a new preview string.
         *
         * - param string value:    The value to set.
         *
         * - return void.
         */
        setPreview: function(value) {
            this.preview.text(value);
        },


        /*
         * =================
         * Attribute emitter.
         * =================
         */


        /*
         * Emit a widget attribute.
         *
         * - param string attr:     The name of the attribute.
         *
         * - return mixed:          The attribute value.
         */
        getAttr: function(attr) {
            return this[attr];
        }

    });


})( jQuery );
