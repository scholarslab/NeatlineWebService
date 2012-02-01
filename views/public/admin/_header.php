<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Custom header template.
 *
 * @package     omeka
 * @subpackage  neatline
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2012 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 */
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title><?php echo $prefix; ?>: <?php echo $title; ?></title>

<!-- Plugin Assets -->
<?php admin_plugin_header(); ?>

<!-- Stylesheets -->
<?php display_css(); ?>

<!-- JavaScripts -->
<?php display_js(); ?>

<link href='http://fonts.googleapis.com/css?family=Droid+Sans|Neuton:200,300,400,700,400italic|Sorts+Mill+Goudy|PT+Serif:400,700,400italic|Buenard|Ovo|Droid+Serif:400,700,400italic|Lusitana:400,700|Patua+One|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300|Comfortaa:400,300,700|Cardo:400,400italic,700' rel='stylesheet' type='text/css'>

</head>
<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
