<?php
require(CONFIG_SM.'Smarty.class.php');

// ----------------------------------- wrapper class -----------
// Create a wrapper class extended from Smarty 
class SFM extends Smarty  
{ 
// set $cache to true and $cache_lifetime to 300 
// when in production for improved performance
  function SFM($cache = false, $cache_lifetime = 0) 
  { 

    // Run Smarty's constructor 
    $this->Smarty(); 

// Change the default template directories 
// uncomment in production
    
    $this->template_dir = CONFIG_SM_TEMPLATE; 
    $this->compile_dir = CONFIG_SM_COMPILE; 
    $this->config_dir = CONFIG_SM_CONFIG; 
    $this->cache_dir = CONFIG_SM_CACHE; 
//	$this->plugins_dir = array(SMARTY_DIR.'plugins','lib/smarty/libs/plugins/ajax');
	$this->plugins_dir = array(SMARTY_DIR.'plugins','lib/smarty/libs/plugins');

    // Change default caching behavior 
    $this->caching = $cache; 
    $this->cache_lifetime = $cache_lifetime; 
  } 
} 
// -------------------------------- wrapper class --------------

?>
