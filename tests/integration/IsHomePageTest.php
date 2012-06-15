<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class NLWS_IsHomePageTest extends NWS_Test_AppTestCase
{

    public function testIsHomePage()
    {

        // not set
        $this->assertNull(get_option('web_service_home_page'));

        // set true
        set_option('web_service_home_page', true);
        $this->assertTrue(get_option('web_service_home_page'));

        //set false
        set_option('web_service_home_page', false);
        $this->assertFalse(get_option('web_service_home_page'));

    }

}
