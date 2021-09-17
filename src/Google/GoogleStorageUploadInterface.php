<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 23:08
 */

namespace nguyenanhung\Upload\Google;

/**
 * Interface GoogleStorageUploadInterface
 *
 * @package   nguyenanhung\Upload\Google
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface GoogleStorageUploadInterface
{
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
    public function setProjectId($projectId);

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
    public function setKeyFilePath($keyFilePath);

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
    public function setBucketName($bucketName);

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
    public function setStorageClass($storageClass);

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
    public function setStorageLocation($storageLocation);

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
    public function setFileData($fileData);

    /**
     * Function addBucket
     *
     * @return \Google\Cloud\Storage\ObjectIterator|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 51:12
     */
    public function addBucket();

    /**
     * Function listBuckets
     *
     * @return \Google\Cloud\Core\Iterator\ItemIterator|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 55:57
     */
    public function listBuckets();

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
    public function getListObject($directoryPrefix = null);

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
    public function handleUpload();
}
