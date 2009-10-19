<?php
ob_start(); /* template body */ ?><p>example</p>aa<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>