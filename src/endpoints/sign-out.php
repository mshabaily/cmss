<?php

use CMSS\Response;

cmss_logout();

send_response(new Response(200, "Logout Successful"));