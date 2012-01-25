/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/*
 * Controls the embed builder application in the /embed view.
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


    $.widget('neatlinewebservice.embedBuilder', {

        options: {

            colors: {
                light_gray: '#a3a3a3',
                dark_gray: '#3a3a3a'
            }

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
            this.widthInput =   $('div.width input');
            this.heightInput =  $('div.height input');
            this.codeInput =    $('div.code textarea');
            this.preview =      $('#embed-preview');
            this.credit =       $('#credit-container');

            // Get starting parameters, bind listeners.
            this._getStartingParams();
            this._addEvents();

            // Set starting code.
            this.setCode();

        },

        /*
         * Get starting parameters out of markup.
         *
         * - return void.
         */
        _getStartingParams: function() {

            this.src =      this.preview.attr('src');
            this.height =   parseInt(this.preview.attr('height'));
            this.width =    parseInt(this.preview.attr('width'));

        },

        /*
         * Bind listeners to the inputs.
         *
         * - return void.
         */
        _addEvents: function() {

            var self = this;

            // Height dragger.
            this.heightInput.integerdragger({
                def: this.height,
                px_per_unit: 0.5,
                change: function(evt, obj) {
                    self.height = obj.value;
                    self.setCode();
                    self.updatePreview()
                }
            });

            // Width dragger.
            this.widthInput.integerdragger({
                def: this.width,
                px_per_unit: 0.5,
                change: function(evt, obj) {
                    self.width = obj.value;
                    self.setCode();
                    self.updatePreview()
                }
            });

        },

        /*
         * Construct the iframe markup.
         *
         * - return string          The <iframe>.
         */
        _buildIframe: function(width, height, src) {

            return '<iframe width="' + width + '" ' +
                'height="' + height + '" ' +
                'frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ' +
                'src="' + src + '"></iframe>';

        },


        /*
         * =================
         * DOM touches.
         * =================
         */


        /*
         * Build and manifest the embed code.
         *
         * - return void.
         */
        setCode: function() {
            var code =      this._buildIframe(this.width, this.height, this.src);
            var credit =    this.credit.html();
            this.codeInput.val(code + credit);
        },

        /*
         * Manifest new dimensions on the preview.
         *
         * - return void.
         */
        updatePreview: function() {
            this.preview.attr({
                height: this.height,
                width: this.width
            });
        }

    });


})( jQuery );
