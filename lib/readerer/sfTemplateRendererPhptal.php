<?php

class sfTemplateRendererPhptal extends sfTemplateRenderer
{
  public function evaluate(sfTemplateStorage $template, array $parameters = array())
  {
    require_once 'PHPTAL.php';

    if ($template instanceof sfTemplateStorageFile)
    {
      $tal = new PHPTAL($template);
    }
    else if ($template instanceof sfTemplateStorageString)
    {
      $filename = tempnam('/tmp', 'TAL');
      file_put_contents($filename, (string)$template);
      $tal = new PHPTAL($filename);
    }

    foreach ($parameters as $k => $v)
    {
      $tal->set($k, $v);
    }

    $result = $tal->execute();
    return $result;
  }
}
