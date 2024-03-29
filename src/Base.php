<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 21:04
 */

namespace nguyenanhung\Upload;

use Exception;
use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Base
 *
 * @package   nguyenanhung\Upload
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class Base implements Environment
{
    /** @var bool Error Status */
    protected $error = false;

    /** @var null|mixed $errorData */
    protected $errorData;

    /**
     * @var array Sample Config
     */
    protected $sampleConfig = array(
        'uploadPath'       => 'uploadPath',
    );

    /**
     * @var array Sample Options
     */
    protected $sampleOptions = array();

    /** @var array $config Upload Service */
    protected $config;

    /** @var Logger|null */
    protected $logger;

    /** @var string $loggerPath */
    protected $loggerPath;

    /** @var string $loggerLevel */
    protected $loggerLevel = 'info';

    /**
     * @var string Filename Prefix
     * @example Bear_
     * @example output file same Bear_uuid-v4
     */
    protected $prefixFilename;

    /** @var string $filename Need to Upload S3 Spaces or Server */
    protected $filename;

    /**
     * @var string Target Upload file on Server
     * @example /var/tmp/upload
     */
    protected $uploadPath;

    /**
     * @var string|array $mediaType
     * @see https://www.iana.org/assignments/media-types/media-types.xhtml
     */
    protected $mediaType;

    /**
     * @var string $fileExtension For example: 'png' or array('jpg', 'png', 'gif').
     */
    protected $fileExtension;

    /**
     * @var string Max File Size, use "B", "K", M", or "G"
     */
    protected $maxFileSize;

    /**
     * @var bool|mixed Upload Result, true on Success or Aws Result Object
     */
    protected $result = false;

    /**
     * @var array Upload  Data or Error Data
     */
    protected $uploadData = array();

    /**
     * Base constructor.
     *
     * @param array $config
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * Function setConfig
     *
     * @param $config
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 06:33
     */
    public function setConfig($config): Base
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Function getConfig
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 08:00
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Function getSampleConfig
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 28:51
     */
    public function getSampleConfig(): array
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
    public function getSampleOptions(): array
    {
        return $this->sampleOptions;
    }

    /**
     * Function getVersion
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 34:17
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Function getLibraryInfo
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 14:42
     */
    public function getLibraryInfo(): array
    {
        return array(
            'name'        => self::PROJECT_NAME,
            'license'     => 'MIT',
            'authorName'  => self::AUTHOR_NAME,
            'authorEmail' => self::AUTHOR_EMAIL,
            'authorUrl'   => self::AUTHOR_WEB,
            'sourceUrl'   => 'https://github.com/nguyenanhung/upload',
        );
    }

    /**
     * Function setLoggerPath
     *
     * @param string $loggerPath
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 13:03
     */
    public function setLoggerPath(string $loggerPath = '/tmp'): Base
    {
        $this->loggerPath = $loggerPath;

        return $this;
    }

    /**
     * Function setLogger
     *
     * @param bool $logger
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 26:34
     */
    public function setLogger(bool $logger = false)
    {
        try {
            if ($logger === true) {
                $useLevel = strtolower($this->loggerLevel);
                switch ($useLevel) {
                    case 'debug':
                        $keyLevel = Logger::DEBUG;
                        break;
                    case 'notice':
                        $keyLevel = Logger::NOTICE;
                        break;
                    case 'warning':
                        $keyLevel = Logger::WARNING;
                        break;
                    case 'error':
                        $keyLevel = Logger::ERROR;
                        break;
                    case 'critical':
                        $keyLevel = Logger::CRITICAL;
                        break;
                    case 'alert':
                        $keyLevel = Logger::ALERT;
                        break;
                    case 'emergency':
                        $keyLevel = Logger::EMERGENCY;
                        break;
                    default:
                        $keyLevel = Logger::INFO;
                }
                $fileName     = $this->loggerPath . '/Log-' . date('Y-m-d') . '.log';
                $stream       = new StreamHandler($fileName, $keyLevel, true, 0777);
                $this->logger = new Logger('upload');
                $this->logger->pushHandler($stream);
            }
        } catch (InvalidArgumentException $exception) {
            if (function_exists('log_message')) {
                log_message('error', $exception->getMessage());
                log_message('error', $exception->getTraceAsString());
            }
        } catch (Exception $exception) {
            if (function_exists('log_message')) {
                log_message('error', $exception->getMessage());
                log_message('error', $exception->getTraceAsString());
            }
        }
    }

    /**
     * Function getUploadResult
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:47
     */
    public function getUploadResult(): bool
    {
        return $this->result;
    }

    /**
     * Function getUploadData
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 07:39
     */
    public function getUploadData(): array
    {
        return $this->uploadData;
    }

    /**
     * Function setPrefixFilename
     *
     * @param $prefixFilename
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 44:04
     */
    public function setPrefixFilename($prefixFilename): Base
    {
        $this->prefixFilename = $prefixFilename;

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
     * @time     : 09/17/2021 43:11
     */
    public function setUploadPath($uploadPath): Base
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    /**
     * Function setFilename
     *
     * @param $filename
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 45:10
     */
    public function setFilename($filename): Base
    {
        $this->filename = $filename;

        return $this;
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
    public function setMediaType($mediaType): Base
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Function setMaxFileSize
     *
     * @param $maxFileSize
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 45:17
     */
    public function setMaxFileSize($maxFileSize): Base
    {
        $this->maxFileSize = $maxFileSize;

        return $this;
    }

    /**
     * Function setFileExtension
     *
     * @param $fileExtension
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 51:42
     */
    public function setFileExtension($fileExtension): Base
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Function isError
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 00:32
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * Function getErrorData
     *
     * @return mixed|null
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 00:48
     */
    public function getErrorData()
    {
        return $this->errorData;
    }
}
