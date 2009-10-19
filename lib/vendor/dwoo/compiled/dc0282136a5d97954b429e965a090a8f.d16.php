<?php
ob_start(); /* template body */ ?><p>example</p><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>