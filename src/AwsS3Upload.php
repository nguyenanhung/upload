<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 18:23
 */

namespace nguyenanhung\Upload;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

/**
 * Class AwsS3Upload
 *
 * @package   nguyenanhung\Upload
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class AwsS3Upload implements Environment, AwsS3UploadInterface
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

    /**
     * @var array Sample Options
     */
    protected $sampleOptions = array();

    /** @var string $bucketName */
    protected $bucketName = 'nguyenanhung';

    /** @var string $filename Need to Upload S3 Spaces */
    protected $filename;

    /**
     * @var string Target Upload file on S3
     */
    protected $uploadPath;

    /**
     * @var string|array $mediaType
     * @see https://www.iana.org/assignments/media-types/media-types.xhtml
     */
    protected $mediaType = 'image/jpeg';

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
    public function __construct($config = array())
    {
        $this->S3 = new S3Client($config);
        if (isset($config['bucketName'])) {
            $this->bucketName = $config['bucketName'];
        }
        if (isset($config['uploadPath'])) {
            $this->uploadPath = $config['uploadPath'];
        }
    }

    /**
     * Function getVersion
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 34:17
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function getSampleConfig
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 28:51
     */
    public function getSampleConfig()
    {
        return $this->sampleConfig;
    }

    /**
     * Function getSampleOptions
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 53:37
     */
    public function getSampleOptions()
    {
        return $this->sampleOptions;
    }

    /**
     * Function setMediaType
     *
     * @param $mediaType
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 45:20
     */
    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;

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
     * @time     : 09/17/2021 31:13
     */
    public function setBucketName($bucketName)
    {
        $this->bucketName = $bucketName;

        return $this;
    }

    /**
     * Function setUploadPath
     *
     * @param $uploadPath
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 55:08
     */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;

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
    public function getListObject()
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
    public function addBucket()
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
    public function getSignedUrl()
    {
        //Creating a pre signed URL
        $cmd     = $this->S3->getCommand(
            'PutObject',
            array(
                'Bucket'         => $this->bucketName,
                'Key'            => $this->filename,
                'ContentType'    => $this->mediaType,
                'ACL'            => 'public-read',
                'AllowedOrigin'  => '*',
                'AllowedHeaders' => '*'
            )
        );
        $request = $this->S3->createPresignedRequest($cmd, '+20 minutes');

        return $request->getUri();
    }

    /**
     * Function uploadFile
     *
     * @param array $filename
     *
     * @return \Aws\Result|string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 55:47
     */
    public function uploadFile($filename = array())
    {
        try {
            $object = array(
                'Bucket'       => $this->bucketName,
                'Key'          => $this->uploadPath . $filename['name'],
                'SourceFile'   => $filename['tmp_name'],
                'ContentType'  => 'image/png',
                'StorageClass' => 'STANDARD',
                'ACL'          => 'public-read'
            );

            return $this->S3->putObject($object);

        } catch (S3Exception $e) {
            return $e->getMessage();
        }
    }
}
