<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplateLoaderFilesystemForSymfony1 extends sfTemplateLoaderFilesystem
{
  protected
    $context = null,
    $view = null;

  public function __construct(sfView $view, sfContext $context, array $configure = array())
  {
    $this->context = $context;
    $this->view = $view;

    $decoratorDirs = $this->context->getConfiguration()->getDecoratorDirs();
    foreach ($decoratorDirs as $k => $v)
    {
      $decoratorDirs[$k] = $v.'/%name%';
    }

    $templateDirs = array_merge(array($this->view->getDirectory().'/%name%'), $decoratorDirs);
    parent::__construct($templateDirs);
  }
}
