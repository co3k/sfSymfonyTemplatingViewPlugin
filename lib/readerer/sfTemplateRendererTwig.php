<?php

class sfTemplateRendererTwig extends sfTemplateRenderer
{
  public function evaluate(sfTemplateStorage $template, array $parameters = array())
  {
    $loader = new Twig_Loader_String();
    $twig = new Twig_Environment($loader);

    if ($template instanceof sfTemplateStorageFile)
    {
      $body = file_get_contents((string)$template);
    }
    else if ($template instanceof sfTemplateStorageString)
    {
      $body = (string)$template;
    }

    $twigTpl = $twig->loadTemplate($body);

    return $twigTpl->render($parameters);
  }
}
