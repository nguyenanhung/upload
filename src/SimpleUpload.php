<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 17:33
 */

namespace nguyenanhung\Upload;

use Exception;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;
use Upload\Validation\Extension;

/**
 * Class SimpleUpload
 *
 * @package   nguyenanhung\Upload
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SimpleUpload implements Environment, SimpleUploadInterface
{
    /**
     * @var string Filename Prefix
     * @example Bear_
     * @example output file same Bear_uuid-v4
     */
    protected $filename;

    /**
     * @var string Target Upload file on Server
     * @example /var/tmp/upload
     */
    protected $uploadPath;

    /**
     * @var string Form ID from HTML form Input, example as foo
     *             <form method="POST" enctype="multipart/form-data">
     *                  <input type="file" name="foo" value=""/>
     *                  <input type="submit" value="Upload File"/>
     *             </form>
     */
    protected $formId;

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
     * @var bool Upload Result, true on Success
     */
    protected $result = false;

    /**
     * @var array Upload  Data or Error Data
     */
    protected $uploadData = array();

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
     * Function getUploadResult
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:47
     */
    public function getUploadResult()
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
    public function getUploadData()
    {
        return $this->uploadData;
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
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    /**
     * Function setFormId
     *
     * @param $formId
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 45:22
     */
    public function setFormId($formId)
    {
        $this->formId = $formId;

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
    public function setMediaType($mediaType)
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
    public function setMaxFileSize($maxFileSize)
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
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Function handle
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 09:50
     */
    public function handle()
    {
        if (empty($this->uploadPath) || empty($this->formId)) {
            $this->result = false;
        }

        $storage  = new FileSystem($this->uploadPath);
        $file     = new File($this->formId, $storage);
        $fileName = $this->filename . date('Y-m-d') . '-' . generate_uuid_v4();
        $file->setName($fileName);

        // Validate file upload
        $maxSize = empty($this->maxFileSize) ? '5M' : $this->maxFileSize;
        if (empty($this->mediaType)) {
            $mediaType = array("image/png", "image/jpg", "image/jpeg", "image/gif", "image/bmp");
        } else {
            $mediaType = $this->mediaType;
        }
        if (empty($this->fileExtension)) {
            $fileExtension = array('png', 'jpg', 'gif', 'txt', 'md');
        } else {
            $fileExtension = $this->fileExtension;
        }
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations(
            array(
                // Ensure file is of type "image/png"
                new Mimetype($mediaType),

                //You can also add multi mimetype validation
                //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

                // Ensure file is no larger than 5M (use "B", "K", M", or "G")
                new Size($maxSize),

                // Valid file Extension
                new Extension($fileExtension)
            )
        );

        // Try to upload file
        try {
            // Success!
            $this->result = $file->upload();
            // Access data about the file that has been uploaded
            $this->uploadData = array(
                'name'       => $file->getNameWithExtension(),
                'extension'  => $file->getExtension(),
                'mime'       => $file->getMimetype(),
                'size'       => $file->getSize(),
                'md5'        => $file->getMd5(),
                'dimensions' => $file->getDimensions()
            );
        } catch (Exception $e) {
            // Fail!
            $errors = $file->getErrors();
            if (function_exists('log_message')) {
                // Logging if use CodeIgniter Framework
                log_message('error', 'Upload Error: ' . json_encode($errors));
            }
            $this->result     = false;
            $this->uploadData = $errors;
        }

        return $this;
    }
}
