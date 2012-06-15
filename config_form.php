<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
?>

<div class="field">

<label for="web_service_home_page">
  <?php echo __('Make NL Web Service the Home Page?'); ?>
</label>
<?php

echo __v()->formCheckbox(
    'web_service_home_page',
    true,
    array('checked'=>(boolean)get_option('web_service_home_page')
  )
);
?>

</div>
