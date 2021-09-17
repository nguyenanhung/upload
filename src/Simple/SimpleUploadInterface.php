<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 18:13
 */

namespace nguyenanhung\Upload\Simple;

/**
 * Interface SimpleUploadInterface
 *
 * @package   nguyenanhung\Upload\Simple
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface SimpleUploadInterface
{
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
     * Function handleUpload
     *
     * @return mixed
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 52:58
     */
    public function handleUpload();
}
