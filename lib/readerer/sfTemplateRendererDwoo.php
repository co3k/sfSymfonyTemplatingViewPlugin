<?php

class sfTemplateRendererDwoo extends sfTemplateRenderer
{
  public function evaluate(sfTemplateStorage $template, array $parameters = array())
  {
    $dwoo = new Dwoo();

    if ($template instanceof sfTemplateStorageFile)
    {
      $tpl = new Dwoo_Template_String(file_get_contents((string)$template));
    }
    else if ($template instanceof sfTemplateStorageString)
    {
      $tpl = new Dwoo_Template_String((string)$template);
    }

    return $dwoo->get($tpl, $parameters);
  }
}


