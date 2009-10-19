<?php
/**
 * PHPTAL templating engine
 *
 * PHP Version 5
 *
 * @category HTML
 * @package  PHPTAL
 * @author   Laurent Bedubourg <lbedubourg@motion-twin.com>
 * @author   Kornel Lesiński <kornel@aardvarkmedia.co.uk>
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @version  SVN: $Id: DefineSlot.php 605 2009-05-03 02:50:26Z kornel $
 * @link     http://phptal.org/
 */

/**
 * METAL Specification 1.0
 *
 *      argument ::= Name
 *
 * Example:
 *
 *      <table metal:define-macro="sidebar">
 *        <tr><th>Links</th></tr>
 *        <tr><td metal:define-slot="links">
 *          <a href="/">A Link</a>
 *        </td></tr>
 *      </table>
 *
 * PHPTAL: (access to slots may be renamed)
 *
 *  <?php function XXXX_macro_sidebar($tpl) { ? >
 *      <table>
 *        <tr><th>Links</th></tr>
 *        <tr>
 *        <?php if (isset($tpl->slots->links)): ? >
 *          <?php echo $tpl->slots->links ? >
 *        <?php else: ? >
 *        <td>
 *          <a href="/">A Link</a>
 *        </td></tr>
 *      </table>
 *  <?php } ? >
 *
 * @package PHPTAL
 * @subpackage Php.attribute.metal
 * @author Laurent Bedubourg <lbedubourg@motion-twin.com>
 */
class PHPTAL_Php_Attribute_METAL_DefineSlot extends PHPTAL_Php_Attribute
{
    public function before(PHPTAL_Php_CodeWriter $codewriter)
    {
        $codewriter->doIf('$ctx->hasSlot('.$codewriter->str($this->expression).')');
        $codewriter->pushCode('echo $ctx->getSlot('.$codewriter->str($this->expression).')');
        $codewriter->doElse();
    }

    public function after(PHPTAL_Php_CodeWriter $codewriter)
    {
        $codewriter->doEnd();
    }
}

