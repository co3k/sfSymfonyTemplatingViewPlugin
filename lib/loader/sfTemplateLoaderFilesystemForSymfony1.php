<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplateLoaderFilesystemForSymfony1 extends sfTemplateAbstractLoader
{
  protected $templateDirs = array();

  public function configure()
  {
    $decoratorDirs = $this->context->getConfiguration()->getDecoratorDirs();
    foreach ($decoratorDirs as $k => $v)
    {
      $decoratorDirs[$k] = $v.'/%name%';
    }

    $this->templateDirs = array_merge(array($this->view->getDirectory().'/%name%'), $decoratorDirs);
  }

  public function doLoad($template, $renderer = 'php')
  {
    foreach ($this->templateDirs as $dir)
    {
      if (is_file($file = strtr($dir, array('%name%' => $template))))
      {
        return new sfTemplateStorageFile($file, $renderer);
      }
    }
  }
}
