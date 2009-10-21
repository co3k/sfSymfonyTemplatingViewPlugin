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
    $renderers = array();
    foreach (sfConfig::get('app_sfSymfonyTemplatingViewPlugin_renderers', array()) as $k => $v)
    {
      $renderers[$k] = new $v();
    }

    $defaultRule = array('php' => array(
      array('loader' => 'sfTemplateSwitchableLoaderFilesystemForSymfony1', 'renderer' => 'php'),
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
    $this->setTemplate($this->actionName.$this->viewName);
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
