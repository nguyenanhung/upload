<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 18:29
 */

namespace nguyenanhung\Upload\S3;

/**
 * Interface S3UploadInterface
 *
 * @package   nguyenanhung\Upload\S3
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface S3UploadInterface
{
    /**
     * Function setBucketName
     *
     * @param $bucketName
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 31:13
     */
    public function setBucketName($bucketName);

    /**
     * Function getListObject
     *
     * @return \Aws\Result
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 31:58
     */
    public function getListObject();

    /**
     * Function addBucket
     *
     * @return \Aws\Result
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 32:08
     */
    public function addBucket();

    /**
     * Function getSignedUrl
     *
     * @return \Psr\Http\Message\UriInterface
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 37:15
     */
    public function getSignedUrl();

    /**
     * Function handleUpload
     *
     * @param array $filename
     *
     * @return $this|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 01:43
     */
    public function handleUpload($filename = array());
}
