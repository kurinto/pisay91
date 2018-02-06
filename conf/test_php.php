<?php
require 'global.conf';
if ( !is_writable(CONFIG_SM_COMPILE) ) echo CONFIG_SM_COMPILE." -- <FONT color=\"#FF0000\">not writable...</FONT><BR>\n\r";
else echo CONFIG_SM_COMPILE." -- <FONT color=\"#00C000\">OK</FONT><BR>\n\r";

if ( !is_writable(CONFIG_SM_CACHE) ) echo CONFIG_SM_CACHE." -- <FONT color=\"#FF0000\">not writable...</FONT><BR>\n\r";
else echo CONFIG_SM_CACHE." -- <FONT color=\"#00C000\">OK</FONT><BR>\n\r";

phpinfo();
?>