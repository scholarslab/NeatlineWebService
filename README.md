# Neatline Web Service

Neatline Web Service provides a public-facing facade for the Neatline plugin that makes it possible for public users to create accounts and use Neatline as a hosted web application.

## Installation and Configuration

Neatline is a plugin for [Omeka][omeka], an open-source web publishing platform that makes it possible to create, curate, and display archival collections based on Dublin Core or EAD metadata. While the web service is designed to make it easy to experiment with Neatline and build exhibits based on real-geography base layers, using Neatline _directly_, inside of the Omeka, makes it possible to base Neatline exhibits on an underlying archive of Omeka items that conforms to rigorous and portable metadata standards.

Installing Omeka + Neatline is a two-step process: Omeka first, then the Neatline plugin. Omeka is a PHP/MySQL application that will run on almost any commercial hosting provider. Before you start, you'll need:

  1. A hosting environment that supports PHP and MySQL;
  2. A way to transfer files onto your server space and make simple text edits. In most cases, a simple FTP client like [FileZilla][filezilla] works well. 
  3. Credentials for a MySQL database user on your server and the name of a fresh, production database for the Omeka installation. If you don't already have a database user account, most commercial hosting providers provide access to a point-and-click database administration tool like phpMyAdmin where you can create databases and users.

#### Install Omeka

For detailed instructions on installing Omeka, refer to [Omeka's official documentation][omeka-install-documentation].

#### Install Neatline

  1. Go to the [Neatline download][neatline-download] page and download the Neatline plugin.
  2. Once the file is finished downloading, uncompress the .zip file and place the "Neatline" directory in the plugins/ folder in your Omeka installation.
  4. Open the "plugin.ini" file in the Neatline directory and change the line 'saas="false"' to 'saas="true"'.
  3. Open a web browser and go to _your-omeka-site.org/admin_, enter your administrative credentials, and click on the "Settings" button
     at the top right of the screen.
  4. Click on the "Plugins" tab in the vertical column on the left and find the listing for the Neatline plugin.
  5. Click the "Install" button.

#### Install Neatline Web Service

  1. Go to the [Neatline Web Service download][neatline-web-service-download] page and download the plugin.
  2. Once the file is finished downloading, uncompress the .zip file and place the "NeatlineWebService" directory in the plugins/ folder in your Omeka installation.
  3. Open a web browser and go to _your-omeka-site.org/admin_, enter your administrative credentials, and click on the "Settings" button
     at the top right of the screen.
  4. Click on the "Plugins" tab in the vertical column on the left and find the listing for the Neatline Web Service plugin.
  5. Click the "Install" button.

By default, the webservice application is accessed off of the /webservice route slug. So, if your Omeka site is installed at _www.yoursite.org_, the webservice would be served off of _www.yoursite.org/webservice_. To change this top-level slug, edit the value of the "saas_slug" parameter in the "plugin.ini" file.

## Creating and Editing Exhibits

#### Create a User Account

To create a webservice user account, go to _www.yoursite.org/webservice/login_. Enter a username, email, and password, and click "Sign Up."

#### Create a New Exhibit

  1. Click the "New Exhibit" button.
  2. Enter a title for the exhibit. The title will be displayed in large text at the top of the public display page for the exhibit.
  3. As you type, the form will automatically generate a "URL Slug" in the box below. The slug is a string of hyphenated text that the webservice will use to form the public URL for the exhibit. Below the URL Slug input, the form automatically populates a preview of the final URL for the exhibit. If you want to use a custom URL slug that's different from the title text, just manually edit the form field for the slug and it will stop mirroring the title text.
  4. Finally, check the "Public" checkbox if you want the exhibit to be publicly accessible. As long as this box is left unchecked, visitors to the public URL for the exhibit will see a "Coming Soon" placeholder. You can come back to this page at any time and toggle this option on and off.  
  5. Click the "Create" button. You'll be redirected to your "Browse Exhibits" page, where you'll see a listing for the new exhibit.

#### Edit Exhibit Information

After creating an exhibit, you may want to go back and change some of the options that you set at the beginning. 

  1. Find the listing for the exhibit that you want to edit and click the "edit details" link below the exhibit title.
  2. You'll get an edit form that's identical to the one that you used to create the exhibit. Edit the Title, URL Slug, or Public options, and click "Save" to commit the changes.

#### View the Public Display Page for an Exhibit

Neatline generates a full-screen page for each of your exhibits that serves as the primary publicly-facing "home" for the exhibit. When you share the  exhibit with other people, you'll want to point them to this page.

  1. In the browse exhibits view, click the "public" link under the exhibit title to go to the full-screen view.

If you do not want the exhibit to be publicly-visible, uncheck the "Public" checkbox in the "edit details" form.

#### Embed An Exhibit 

In addition to providing the full-screen view for an exhibit, Neatline also makes it possible to embed exhibits in any context where HTML markup is allowed. For example, you might want to include a small version of an exhibit in a Wordpress blog post. Neatline includes a dynamic application that lets you configure the dimensions of the embedded exhibit and auto-generates the HTML markup.

  1. Find the listing for the exhibit that you want to embed on the "Browse Exhibits" page and click the "embed" link below the title.
  2. Use the Width and Height inputs to set the dimensions for the embedded exhibit. To increase or decrease the values in the inputs, click on the field and drag the cursor up and down on the page. The value in the input will go up and down, and the preview of the exhibit at the bottom of the page will automaticaly update. If you already know the dimensions that you want for the exhibit, you can also just type directly into the fields.
  3. Once you've set the dimensions, just copy the contents of the "Embed Code" field and paste the HTML into the destination context - a different website, a blog post, a forum, etc.

#### Delete An Exhibit 

  1. Find the listing for the exhibit that you want to delete on the "Browse Exhibits" page and click the "delete" link below the title.
  2. You'll be taken to a confirmation page. **Deleting an exhibit permanently removes the exhibit and all record data associated with it. A deleted exhibit cannot be restored.**
  3. Click "Yes, delete." You'll be taken back to the "Browse Exhibits" page.

[omeka]: http://omeka.org
[omeka-install-documentation]: http://omeka.org/codex/Installation 
[omeka-download]: http://omeka.org/download 
[omeka-github]: https://github.com/omeka/Omeka
[neatline-github]: https://github.com/scholarslab/Neatline
[neatline-maps-github]: https://github.com/scholarslab/NeatlineMaps
[geoserver]: http://geoserver.org
[geoserver-install-documentation]:http://docs.geoserver.org/stable/en/user/installation/index.html
[openstreetmap]: http://www.openstreetmap.org
[neatline-webservice]: http://sandbox.neatline.org
[neatline-webservice-register]: http://sandbox.neatline.org/register
[filezilla]: http://filezilla-project.org/
[neatline-download]: http://neatline.org/download
[neatline-web-service-download]: http://neatline.org/download
