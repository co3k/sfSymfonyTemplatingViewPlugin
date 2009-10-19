<?php

class sfTemplateRendererSmarty extends sfTemplateRenderer
{
  public function evaluate(sfTemplateStorage $template, array $parameters = array())
  {
    require_once 'Smarty.class.php';
    $smarty = new Smarty();
    $smarty->assign($parameters);

    $smarty->template_dir = '/tmp';
    $smarty->compile_dir  = '/tmp';
    $smarty->config_dir   = '/tmp';
    $smarty->cache_dir    = '/tmp';

    if ($template instanceof sfTemplateStorageFile)
    {
      return $smarty->fetch($template);
    }
    else if ($template instanceof sfTemplateStorageString)
    {
      $filename = tempnam('/tmp', 'SMARTY');
      file_put_contents($filename, (string)$template);
      $result = $smarty->fetch($filename);

      unlink($filename);

      return $result;
    }

    return false;
  }
}
