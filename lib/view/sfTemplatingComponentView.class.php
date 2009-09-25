<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplatingComponentView extends sfPHPView
{
  protected
    $loader = null,
    $engine = null;

  /**
   * Executes any presentation logic for this view.
   */
  public function execute()
  {
    $decoratorDirs = $this->context->getConfiguration()->getDecoratorDirs();
    foreach ($decoratorDirs as $k => $v)
    {
      $decoratorDirs[$k] = $v.'/%name%';
    }

    $templateDirs = array_merge(array($this->getDirectory().'/%name%'), $decoratorDirs);

    $this->loader = new sfTemplateLoaderFilesystem($templateDirs);
    $this->engine = new sfTemplateEngine($this->loader);
  }

  /**
   * Retrieves the template engine associated with this view.
   */
  public function getEngine()
  {
    return $this->engine;
  }

  /**
   * Configures template.
   */
  public function configure()
  {
    $this->setTemplate($this->actionName.$this->viewName.$this->getExtension());

    if (!$this->directory)
    {
      $this->setDirectory($this->context->getConfiguration()->getTemplateDir($this->moduleName, $this->getTemplate()));
    }
  }

  /**
   * Renders the presentation.
   */
  public function render()
  {
    $this->loadCoreAndStandardHelpers();

    $this->attributeHolder->set('sf_type', 'action');

    return $this->getEngine()->render($this->getTemplate(), $this->attributeHolder->toArray());
  }
}
