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
 * @version  SVN: $Id: FileSource.php 630 2009-06-05 23:04:32Z kornel $
 * @link     http://phptal.org/
 */

/**
 * Reads template from the filesystem
 *
 * @package PHPTAL
 */
class PHPTAL_FileSource implements PHPTAL_Source
{
    private $_path;
    
    public function __construct($path)
    {
        $this->_path = realpath($path);
        if ($this->_path === false) throw new PHPTAL_IOException("Unable to find real path of file '$path'");
    }

    public function getRealPath()
    {
        return $this->_path;
    }

    public function getLastModifiedTime()
    {
        return filemtime($this->_path);
    }

    public function getData()
    {
        $content = file_get_contents($this->_path);
        
        // file_get_contents returns "" when loading directory!?
        if (false === $content || ("" === $content && is_dir($this->_path))) {
            throw new PHPTAL_IOException("Unable to load file ".$this->_path);
        }
        return $content;
    }
}

/**
 * Finds template on disk by looking through repositories first
 *
 * @package PHPTAL
 */
class PHPTAL_FileSourceResolver implements PHPTAL_SourceResolver
{
    public function __construct($repositories)
    {
        $this->_repositories = $repositories;
    }

    public function resolve($path)
    {
        foreach ($this->_repositories as $repository) {
            $file = $repository . DIRECTORY_SEPARATOR . $path;
            if (file_exists($file)) {
                return new PHPTAL_FileSource($file);
            }
        }

        if (file_exists($path)) {
            return new PHPTAL_FileSource($path);
        }

        return null;
    }

    private $_repositories;
}
