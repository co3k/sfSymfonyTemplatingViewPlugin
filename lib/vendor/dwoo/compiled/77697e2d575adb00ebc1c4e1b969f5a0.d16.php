<?php
ob_start(); /* template body */ ?><p>empty</p><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>