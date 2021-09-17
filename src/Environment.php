<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:55
 */

namespace nguyenanhung\Upload;

/**
 * Interface Environment
 *
 * @package   nguyenanhung\Upload
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface Environment
{
    const VERSION       = '1.0.1.1';
    const LAST_MODIFIED = '2021-09-17';
    const AUTHOR_NAME   = 'Hung Nguyen';
    const AUTHOR_EMAIL  = 'dev@nguyenanhung.com';
    const PROJECT_NAME  = 'Upload Manager';
    const TIMEZONE      = 'Asia/Ho_Chi_Minh';
    const USE_BENCHMARK = true;
    const USE_DEBUG     = false;

    /**
     * Hàm lấy thông tin phiên bản Package
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/13/18 15:12
     *
     * @return string Current Project Version, VD: 1.0.0
     */
    public function getVersion();
}
