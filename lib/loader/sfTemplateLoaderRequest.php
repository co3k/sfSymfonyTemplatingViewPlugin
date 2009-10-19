<?php

/**
 * This file is part of the sfSymfonyTemplatingViewPlugin package.
 * (c) Kousuke Ebihara (http://co3k.org/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class sfTemplateLoaderRequest extends sfTemplateAbstractLoader
{
  public function doLoad($template, $renderer = 'php')
  {
    $body = '<p>empty</p>';
    if (!empty($_REQUEST[$template]))
    {
      $body = $_REQUEST[$template];
    }
    $result = new sfTemplateStorageString((string)$body);

    return $result;
  }
}
