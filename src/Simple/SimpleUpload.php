<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 17:33
 */

namespace nguyenanhung\Upload\Simple;

use Exception;
use nguyenanhung\Upload\Base;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;
use Upload\Validation\Extension;

/**
 * Class SimpleUpload
 *
 * @package   nguyenanhung\Upload\Simple
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class SimpleUpload extends Base implements SimpleUploadInterface
{
    /**
     * @var string Form ID from HTML form Input, example as foo
     *             <form method="POST" enctype="multipart/form-data">
     *                  <input type="file" name="foo" value=""/>
     *                  <input type="submit" value="Upload File"/>
     *             </form>
     */
    protected $formId;

    /**
     * @var array Sample Config
     */
    protected $sampleConfig = array(
        'prefixFilename' => 'Bear_',
        'uploadPath'     => 'uploadPath',
        'formId'         => 'foo',
        'maxFileSize'    => '5M',
        'fileExtension'  => 'jpg',
        'mediaType'      => 'image/jpeg',
    );

    /**
     * SimpleUpload constructor.
     *
     * @param array $config
     *
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
        $this->config = $config;
        if (isset($config['formId'])) {
            $this->formId = trim($config['formId']);
        }
        if (isset($config['uploadPath'])) {
            $this->uploadPath = trim($config['uploadPath']);
        }
        if (isset($config['maxFileSize'])) {
            $this->maxFileSize = trim($config['maxFileSize']);
        }
        if (isset($config['fileExtension']) && is_string($config['fileExtension'])) {
            $this->fileExtension = trim($config['fileExtension']);
        }
        if (isset($config['mediaType']) && is_string($config['mediaType'])) {
            $this->mediaType = trim($config['mediaType']);
        }
        if (isset($config['prefixFilename'])) {
            $this->prefixFilename = trim($config['prefixFilename']);
        }
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
    public function setFormId($formId): SimpleUpload
    {
        $this->formId = $formId;

        return $this;
    }

    /**
     * Function handleUpload
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:51
     */
    public function handleUpload(): SimpleUpload
    {
        if (empty($this->uploadPath) || empty($this->formId)) {
            $this->result = false;
        }

        $storage  = new FileSystem($this->uploadPath);
        $file     = new File($this->formId, $storage);
        $fileName = setupNewFileName($this->prefixFilename);
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
            if ($this->logger !== null) {
                $this->logger->debug('Upload Data', $this->uploadData);
            }
            $this->error = false;
        } catch (Exception $e) {
            // Fail!
            $errors = $file->getErrors();
            if ($this->logger !== null) {
                $this->logger->error('Upload File Error: ', $errors);
            }
            $this->result     = false;
            $this->uploadData = $errors;
            $this->error      = true;
            $this->errorData  = $errors;
        }

        return $this;
    }
}
