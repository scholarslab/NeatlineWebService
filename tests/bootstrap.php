<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

if (!($omekaDir = getEnv('OMEKA_DIR'))) {
    $omekaDir = dirname(dirname(dirname(dirname(__FILE__))));
}

require_once $omekaDir . '/application/tests/bootstrap.php';
require_once 'NWS_Test_AppTestCase.php';
