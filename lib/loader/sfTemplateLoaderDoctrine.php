<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplateLoaderDoctrine extends sfTemplateLoader
{
  protected
    $context = null,
    $view = null,
    $storage = null;

  public function __construct(sfView $view, sfContext $context, array $configure = array())
  {
    $this->context = $context;
    $this->view = $view;

    $this->storage = 'sfTemplateStorageFile';
    if (isset($configure['storage']))
    {
      $this->storage = $configure['storage'];
    }
  }

  public function load($template, $renderer = 'php')
  {
    $string = Doctrine::getTable('Template')->findOneByName($template);
    if (!$string)
    {
      return $string;
    }

    $result = new $this->storage((string)$string);

    return $result;
  }
}
