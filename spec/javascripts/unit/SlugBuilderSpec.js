/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/*
 * Unit tests for the slug builder application.
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

describe('Slug Builder', function() {

    var form;
    var title;
    var slug;
    var preview;

    beforeEach(function() {

        // Run the builder on the form fixture.
        loadFixtures('add-form.html');
        form = $('#add-form');
        form.slugBuilder();

        // Get component markup.
        title =     form.slugBuilder('getAttr', 'title');
        slug =      form.slugBuilder('getAttr', 'slug');
        preview =   form.slugBuilder('getAttr', 'preview');

    });

    describe('slug input interaction', function() {

        it('should replace space characters with "-" in the slug input', function() {

            var e = $.Event('keydown');
            e.which = 32;
            slug.trigger(e);

            expect(slug.val()).toEqual('-');

        });

        it('should append the "-" to the end of existing text in the slug input', function() {

            slug.val('slug');

            var e = $.Event('keydown');
            e.which = 32;
            slug.trigger(e);

            expect(slug.val()).toEqual('slug-');

        });

    });

});
