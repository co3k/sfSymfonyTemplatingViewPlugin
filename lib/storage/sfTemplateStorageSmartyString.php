<?php

class sfTemplateStorageSmartyString extends sfTemplateStorageString
{
  public function getRenderer()
  {
    return 'smarty';
  }
}
