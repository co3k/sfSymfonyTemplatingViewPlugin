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
    $loaders = sfConfig::get('app_sfSymfonyTemplatingViewPlugin_loader', array('default' => array(
      'class' => 'sfTemplateLoaderFilesystemForSymfony1', 'storage' => 'sfTemplateStorageFile',
    )));

    $this->loader = new sfTemplateLoaderChain();
    foreach ($loaders as $loader)
    {
      $this->loader->addLoader(new $loader['class']($this, $this->context, array('storage' => $loader['storage'])));
    }

    $defaultRule = array('php' => array(
      array('loader' => 'sfTemplateLoaderFilesystemForSymfony1', 'renderer' => 'php'),
    ));
    $rules = array_merge($defaultRule, sfConfig::get('app_sfSymfonyTemplatingViewPlugin_rules', array()));

    $this->loader = new sfTemplateLoaderSwitcher($rules, $this, $this->context);
    $this->engine = new sfTemplateEngine($this->loader, $renderers);
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
