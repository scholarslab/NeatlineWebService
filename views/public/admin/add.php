<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Add template.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<?php
echo $this->partial('admin/_header.php', array(
    'prefix' => 'Neatline Web Service',
    'title' => 'Create Exhibit'
));
?>

<div class="container">

    <!-- Logo. -->
    <div class="page-header">
        <?php echo $this->partial('admin/_logo.php'); ?>
    </div>

    <div class="row">

        <div class="span4">
            <h2>Create Exhibit</h2>
            <p>Enter a title, URL slug, and check whether or not the exhibit should publicly visible.</p>
        </div>

        <div class="span12">
            <form method="post" class="form-stacked">

                <fieldset>

                    <div class="clearfix <?php echo nlws_getErrorClass($errors, 'title', 'error'); ?>">
                        <label for="username">Title: *</label>
                        <div class="input title">
                            <input name="title" type="text" value="<?php echo $title; ?>" class="span5" />
                            <span class="help-block">The title is publically displayed at the top of the exhibit.</span>
                            <?php if (array_key_exists('title', $errors)): ?>
                                <span class="help-inline"><?php echo $errors['title']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="clearfix <?php echo nlws_getErrorClass($errors, 'slug', 'error'); ?>">
                        <label for="slug">URL Slug: *</label>
                        <div class="input slug">
                            <input name="slug" type="text" value="<?php echo $slug; ?>" class="span5" />
                            <span class="help-block">The URL slug is used to form the public URL for the exhibit.</span>
                            <?php if (array_key_exists('slug', $errors)): ?>
                                <span class="help-inline"><?php echo $errors['slug']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="clearfix checkbox">
                        <label class="checkbox">
                            <input type="checkbox" name="public">
                            <span>Public</span>
                        </label>
                        <span class="help-block">By default, exhibits are only visible to you.</span>
                    </div>

                </fieldset>

                <div class="actions">
                    <button type="submit" class="btn primary large">Create</button>
                </div>

            </form>
        </div>

    </div>

</div>
