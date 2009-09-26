<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class ApplicationConfigurationMock extends ProjectConfiguration
{
  public function getTemplateDir($moduleName, $templateFile)
  {
    return dirname(__FILE__).'/fixtures/'.$moduleName;
  }

  public function getTemplateDirs($moduleName)
  {
    return array(dirname(__FILE__).'/fixtures/'.$moduleName);
  }

  public function getDecoratorDirs()
  {
    return array(dirname(__FILE__).'/fixtures/template');
  }

  public function loadHelpers($helpers, $moduleName = '')
  {
  }
}

