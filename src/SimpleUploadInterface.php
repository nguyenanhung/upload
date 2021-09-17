<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 18:13
 */

namespace nguyenanhung\Upload;

/**
 * Interface SimpleUploadInterface
 *
 * @package   nguyenanhung\Upload
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface SimpleUploadInterface
{
    /**
     * Function getUploadResult
     *
     * @return bool
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:47
     */
    public function getUploadResult();

    /**
     * Function getUploadData
     *
     * @return array
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 07:39
     */
    public function getUploadData();

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
    public function setUploadPath($uploadPath);

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
    public function setFormId($formId);

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
    public function setMediaType($mediaType);

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
    public function setMaxFileSize($maxFileSize);

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
    public function setFileExtension($fileExtension);

    /**
     * Function handle
     *
     * @return $this
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 09:50
     */
    public function handle();
}
