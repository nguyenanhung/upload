<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 22:17
 */

namespace nguyenanhung\Upload\Google;

use Google\Cloud\Core\Exception\GoogleException;
use nguyenanhung\Upload\Base;
use Google\Cloud\Storage\StorageClient;

/**
 * Class GoogleStorageUpload
 *
 * @package   nguyenanhung\Upload\Google
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class GoogleStorageUpload extends Base implements GoogleStorageUploadInterface
{
    /**
     * @var array Sample Config
     * @see https://github.com/googleapis/google-cloud-php-storage/blob/master/README.md
     */
    protected $sampleConfig = array(
        'projectId'   => 'xxx',
        'keyFilePath' => '/path/to/keyfile.json',
    );

    /** @var \Google\Cloud\Storage\StorageClient $storage */
    protected $storage;

    /**
     * @var string GOOGLE_CLOUD_PROJECT
     * @see https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md
     */
    protected $projectId;

    /**
     * @var string GOOGLE_APPLICATION_CREDENTIALS FILE
     * @see https://github.com/googleapis/google-cloud-php/blob/master/AUTHENTICATION.md
     */
    protected $keyFilePath;

    /**
     * @var string $bucketName
     * @see https://cloud.google.com/storage/docs/naming-buckets
     * @see https://github.com/googleapis/google-cloud-php-storage/blob/master/README.md
     */
    protected $bucketName = 'nguyenanhung';

    /**
     * @var string $storageClass
     * @see https://cloud.google.com/storage/docs/storage-classes
     */
    protected $storageClass;

    /**
     * @var string $storageLocation
     * @see https://cloud.google.com/storage/docs/locations
     */
    protected $storageLocation;

    /**
     * @var mixed File Data
     * @see      https://cloud.google.com/storage/docs/uploading-objects#storage-upload-object-code-sample
     * @example  fopen('/path/your/file', 'r');
     */
    protected $fileData;

    /**
     * GoogleStorageUpload constructor.
     *
     * @param array $config
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->config = $config;
        if (isset($config['projectId'])) {
            $this->projectId = trim($config['projectId']);
        }
        if (isset($config['storageClass'])) {
            $this->storageClass = trim($config['storageClass']);
        }
        if (isset($config['storageLocation'])) {
            $this->storageLocation = trim($config['storageLocation']);
        }
        if (isset($config['keyFilePath']) && file_exists($config['keyFilePath'])) {
            $this->keyFilePath = $config['keyFilePath'];
        }
        $this->storage = new StorageClient();
    }

    /**
     * Function setProjectId
     *
     * @param $projectId
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 30:13
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Function setKeyFilePath
     *
     * @param $keyFilePath
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 30:33
     */
    public function setKeyFilePath($keyFilePath)
    {
        $this->keyFilePath = $keyFilePath;

        return $this;
    }

    /**
     * Function setBucketName
     *
     * @param $bucketName
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 39:31
     */
    public function setBucketName($bucketName)
    {
        $this->bucketName = $bucketName;

        return $this;
    }

    /**
     * Function setStorageClass
     *
     * @param $storageClass
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:00
     */
    public function setStorageClass($storageClass)
    {
        $this->storageClass = $storageClass;

        return $this;
    }

    /**
     * Function setStorageLocation
     *
     * @param $storageLocation
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 51:56
     */
    public function setStorageLocation($storageLocation)
    {
        $this->storageLocation = $storageLocation;

        return $this;
    }

    /**
     * Function setFileData
     *
     * @param $fileData
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 05:53
     */
    public function setFileData($fileData)
    {
        $this->fileData = $fileData;

        return $this;
    }

    /**
     * Function addBucket
     *
     * @return \Google\Cloud\Storage\ObjectIterator|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 51:12
     */
    public function addBucket()
    {

        $options = array(
            'storageClass' => $this->storageClass,
            'location'     => $this->storageLocation
        );
        try {
            $bucket        = $this->storage->createBucket($this->bucketName, $options);
            $objectsOption = array(
                'encryption' => array(
                    'defaultKmsKeyName' => null,
                )
            );

            return $bucket->objects($objectsOption);
        } catch (GoogleException $e) {
            if ($this->logger !== null) {
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
            }

            return null;
        }

    }

    /**
     * Function listBuckets
     *
     * @return \Google\Cloud\Core\Iterator\ItemIterator|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 55:57
     */
    public function listBuckets()
    {
        try {
            return $this->storage->buckets();
        } catch (GoogleException $e) {
            if ($this->logger !== null) {
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
            }

            return null;
        }
    }

    /**
     * Function getListObject
     *
     * @param null|string $directoryPrefix
     *
     * @return \Google\Cloud\Storage\ObjectIterator
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 59:31
     */
    public function getListObject($directoryPrefix = null)
    {
        $bucket = $this->storage->bucket($this->bucketName);
        if (!empty($directoryPrefix)) {
            $option = array(
                'prefix' => $directoryPrefix
            );

            return $bucket->objects($option);
        }

        return $bucket->objects();
    }

    /**
     * Function handleUpload
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 45:40
     *
     * @see      https://cloud.google.com/storage/docs/uploads-downloads
     * @see      https://cloud.google.com/storage/docs/uploading-objects#storage-upload-object-php
     */
    public function handleUpload()
    {
        $bucket = $this->storage->bucket($this->bucketName);

        // Using Predefined ACLs to manage object permissions, you may
        // upload a file and give read access to anyone with the URL.
        $options = array(
            // see: https://cloud.google.com/storage/docs/access-control/making-data-public#storage-make-object-public-php
            'acl'           => array(),
            'predefinedAcl' => 'publicRead',
            'name'          => setupNewFileName($this->prefixFilename)
        );


        $result = $bucket->upload($this->fileData, $options);

        $this->result = $result;

        return $this;
    }
}
