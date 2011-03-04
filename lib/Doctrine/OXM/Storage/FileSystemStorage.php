<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\OXM\Storage;

use \Doctrine\OXM\Mapping\ClassMetadataInfo;

 /**
  * @author Richard Fullmer <richardfullmer@gmail.com>
  */
class FileSystemStorage implements Storage
{
    /**
     * @var string
     */
    private $storagePath;

    /**
     * @var
     */
    private $fileExtension;

    /**
     *
     */
    private $fileModeBits = 0755;

    /**
     * @var boolean
     */
    private $useNamespaceInPath = true;


    /**
     * Construct a file system store with a specific base path
     */
    public function __construct($baseStoragePath, $defaultFileExtension = 'xml')
    {
        // todo - ensure storage path exists
        $this->storagePath = $baseStoragePath;
        $this->fileExtension = $defaultFileExtension;
    }

    /**
     * Insert the XML into the filesystem with a specific identifier
     *
     * @throws StorageException
     * @param \Doctrine\OXM\Mapping\ClassMetadataInfo $classMetadata
     * @param string $id
     * @param string $xmlContent
     * @return boolean
     */
    public function insert(ClassMetadataInfo $classMetadata, $id, $xmlContent)
    {
        $baseFilePath = $this->_prepareStoragePathForClass($this->_resolveClassName($classMetadata));

        // todo - id should be sanitized for the filesystem
        $baseFilePath .= "/$id.{$this->fileExtension}";
        
        $result = file_put_contents($baseFilePath, $xmlContent);
        if (false === $result) {
            // @codeCoverageIgnoreStart
            throw new StorageException("Entity '$id' could not be saved to the filesystem at path '$baseFilePath'");
            // @codeCoverageIgnoreEnd
        }
        return $result > 0;
    }

    private function _resolveClassName(ClassMetadataInfo $classMetadata)
    {
        if ($this->useNamespaceInPath) {
            return $classMetadata->rootXmlEntityName;
        } else {
            $classParts = explode("\\", $classMetadata->rootXmlEntityName);
            return array_pop($classParts);
        }
    }

    /**
     * Build the realpath to save the xml in a specific folder
     *
     * @param string $className
     * @return string
     */
    private function _prepareStoragePathForClass($className)
    {
        $filePath = $this->_buildStoragePath($className);
        if (!file_exists($filePath)) {
            mkdir($filePath, $this->fileModeBits, true);
        }
        return $filePath;
    }

    /**
     * @param string
     * @return string
     */
    private function _buildStoragePath($className)
    {
        return $this->storagePath . '/' . implode('/', explode("\\", $className));
    }

    /**
     *
     */
    public function load(ClassMetadataInfo $classMetadata, $id)
    {
        // todo - implement load method
    }

    /**
     * 
     */
    public function exists(ClassMetadataInfo $classMetadata, $id)
    {
        $baseFilePath = $this->_buildStoragePath($this->_resolveClassName($classMetadata));
        return is_file($baseFilePath . "/$id.{$this->fileExtension}");
    }

    /**
     * @param string $baseStoragePath
     * @return void
     */
    public function setStoragePath($baseStoragePath)
    {
        $this->storagePath = $baseStoragePath;
    }

    /**
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param string $fileExtension
     * @return void
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @param int $fileModeBits
     * @return void
     */
    public function setFileModeBits($fileModeBits)
    {
        $this->fileModeBits = $fileModeBits;
    }

    /**
     * @return int
     */
    public function getFileModeBits()
    {
        return $this->fileModeBits;
    }

    /**
     * @param boolean $useNamespaceInPath
     * @return void
     */
    public function setUseNamespaceInPath($useNamespaceInPath)
    {
        $this->useNamespaceInPath = $useNamespaceInPath;
    }

    /**
     * @return boolean
     */
    public function getUseNamespaceInPath()
    {
        return $this->useNamespaceInPath;
    }


}