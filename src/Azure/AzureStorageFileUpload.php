<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 22:18
 */

namespace nguyenanhung\Upload\Azure;

use nguyenanhung\Upload\Base;

/**
 * Class AzureStorageFileUpload
 *
 * @package   nguyenanhung\Upload\Azure
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
class AzureStorageFileUpload extends Base
{
    /**
     * AzureStorageFileUpload constructor.
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
