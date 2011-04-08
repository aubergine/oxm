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

use Doctrine\OXM\Mapping\ClassMetadataInfo;

/**
 *
 */
class GitBackedFileStorage implements Storage
{

    public function __construct(FileSystemStorage $fileSystemStorage)
    {
        $this->fileSystemStorage = $fileSystemStorage;
    }

    /**
     * @param \Doctrine\OXM\Mapping\ClassMetadata $classMetadata
     * @param  $id
     * @return boolean
     */
    function delete(ClassMetadataInfo $classMetadata, $id)
    {
        return parent::delete($classMetadata, $id);
    }

    /**
     * @param \Doctrine\OXM\Mapping\ClassMetadata $classMetadata
     * @param  $id
     * @return boolean
     */
    function exists(ClassMetadataInfo $classMetadata, $id)
    {
        return parent::exists($classMetadata, $id);
    }

    /**
     * Load XML from storage
     *
     * @param \Doctrine\OXM\Mapping\ClassMetadata $classMetadata
     * @param  $id
     * @return string
     */
    function load(ClassMetadataInfo $classMetadata, $id)
    {
        return parent::load($classMetadata, $id);
    }

    /**
     * Insert the XML into the storage system with a specific identifier
     *
     * @param ClassMetadata
     * @param string $id
     * @param string $xmlContent
     * @return void
     */
    function insert(ClassMetadataInfo $classMetadata, $id, $xmlContent)
    {
        return parent::insert($classMetadata, $id, $xmlContent);
    }

}
