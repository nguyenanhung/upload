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

use nguyenanhung\Upload\Base;

/**
 * Class GoogleStorageUpload
 *
 * @package   nguyenanhung\Upload\Google
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class GoogleStorageUpload extends Base
{
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
    }
}
