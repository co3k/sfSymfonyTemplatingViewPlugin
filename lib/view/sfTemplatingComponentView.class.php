<?php

/**
* Copyright 2009 Kousuke Ebihara
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
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
