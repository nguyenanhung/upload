<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 18:23
 */

namespace nguyenanhung\Upload\S3;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Result as AwsResult;
use Psr\Http\Message\UriInterface;
use nguyenanhung\Upload\Base;

/**
 * Class AwsS3Upload
 *
 * @package   nguyenanhung\Upload\S3
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class S3Upload extends Base implements S3UploadInterface
{
    /** @var \Aws\S3\S3Client $S3 Object */
    protected $S3;

    /**
     * @var array Sample Config
     * @see https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-encryption-client.html
     */
    protected $sampleConfig = array(
        'endpoint'         => 'https://s3.example.com',
        'region'           => 'sgp1',
        'version'          => 'latest',
        'signatureVersion' => 'v4',
        'credentials'      => array(
            'key'    => 'xxx',
            'secret' => 'xxx',
        ),
        'bucketName'       => 'bucketName',
        'uploadPath'       => 'uploadPath',
    );

    /** @var string $bucketName */
    protected $bucketName = 'nguyenanhung';

    /**
     * AwsS3Upload constructor.
     *
     * @param array $config
     *
     * @see      https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/s3-encryption-client.html
     *
     * @example  $sampleConfig array
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this->config = $config;
        $this->S3     = new S3Client($config);
        if (isset($config['bucketName'])) {
            $this->bucketName = $config['bucketName'];
        }
        if (isset($config['uploadPath'])) {
            $this->uploadPath = $config['uploadPath'];
        }
    }

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
    public function setBucketName($bucketName): S3Upload
    {
        $this->bucketName = $bucketName;

        return $this;
    }

    /**
     * Function getListObject
     *
     * @return \Aws\Result
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 31:58
     */
    public function getListObject(): AwsResult
    {
        return $this->S3->listObjects(array('Bucket' => $this->bucketName));
    }

    /**
     * Function addBucket
     *
     * @return \Aws\Result
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 32:08
     */
    public function addBucket(): AwsResult
    {
        return $this->S3->createBucket(array('Bucket' => $this->bucketName));
    }

    /**
     * Function getSignedUrl
     *
     * @return \Psr\Http\Message\UriInterface
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 37:15
     */
    public function getSignedUrl(): UriInterface
    {
        $objectData = array(
            'Bucket'         => $this->bucketName,
            'Key'            => $this->uploadPath . $this->filename,
            'ContentType'    => $this->mediaType,
            'ACL'            => 'public-read',
            'AllowedOrigin'  => '*',
            'AllowedHeaders' => '*'
        );
        if ($this->logger !== null) {
            $this->logger->debug(ucfirst(__FUNCTION__) . ' with Data: ', $objectData);
        }
        //Creating a pre signed URL
        $cmd     = $this->S3->getCommand('PutObject', $objectData);
        $request = $this->S3->createPresignedRequest($cmd, '+20 minutes');

        return $request->getUri();
    }

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
    public function handleUpload($filename = array())
    {
        try {
            $objectData = array(
                'Bucket'       => $this->bucketName,
                'Key'          => $this->uploadPath . $filename['name'],
                'SourceFile'   => $filename['tmp_name'],
                'ContentType'  => $this->mediaType,
                'StorageClass' => 'STANDARD',
                'ACL'          => 'public-read'
            );
            if ($this->logger !== null) {
                $this->logger->debug(ucfirst(__FUNCTION__) . ' with Data: ', $objectData);
            }
            $this->error      = false;
            $this->result     = $this->S3->putObject($objectData);
            $this->uploadData = $objectData;
        } catch (S3Exception $e) {
            if ($this->logger !== null) {
                $this->logger->error($e->getAwsRequestId());
                $this->logger->error($e->getAwsErrorCode());
                $this->logger->error($e->getAwsErrorType());
                $this->logger->error($e->getAwsErrorMessage());
                $this->logger->error($e->getMessage());
                $this->logger->error($e->getTraceAsString());
            }
            $this->error     = true;
            $this->result    = false;
            $this->errorData = $e;

            return $e->getMessage();
        }

        return $this;
    }
}
