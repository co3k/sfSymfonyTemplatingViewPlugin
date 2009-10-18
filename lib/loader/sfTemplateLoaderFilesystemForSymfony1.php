<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplateLoaderFilesystemForSymfony1 extends sfTemplateAbstractSwitchableLoader
{
  protected $templateDirs = array();

  public function configure()
  {
    $decoratorDirs = $this->context->getConfiguration()->getDecoratorDirs();
    foreach ($decoratorDirs as $k => $v)
    {
      $this->templateDirs[$k] = $v.'/%name%.%extension%';
    }

    $this->templateDirs = array_merge(array($this->view->getDirectory().'/%name%'), $decoratorDirs);
  }

  public function doLoad($template, $renderer = 'php')
  {
    $extension = $this->getParameter('extension', $this->view->getExtension());
    if ('.' === $extension[0])
    {
      $extension = substr($extension, 1);
    }

    $localDir = $this->context->getConfiguration()->getTemplateDir($this->view->getModuleName(), $template.'.'.$extension);
    $this->view->setDirectory($localDir);

    $templateDirs = array_merge($this->templateDirs, array($localDir.'/%name%.%extension%'));
    foreach ($templateDirs as $dir)
    {
      if (is_file($file = strtr($dir, array('%name%' => $template, '%extension%' => $extension))))
      {
        return new sfTemplateStorageFile($file, $renderer);
      }
    }
  }
}
