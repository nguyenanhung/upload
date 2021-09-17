<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 17:28
 */
if (!function_exists('generate_uuid_v4')) {
    /**
     * Function generate_uuid_v4
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 38:05
     */
    function generate_uuid_v4()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', // 32 bits for "time_low"
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 16 bits for "time_mid"
                       mt_rand(0, 0xffff), // 16 bits for "time_hi_and_version",

            // four most significant bits holds version number 4
                       mt_rand(0, 0x0fff) | 0x4000, // 16 bits, 8 bits for "clk_seq_hi_res",

            // 8 bits for "clk_seq_low",

            // two most significant bits holds zero and one for variant DCE1.1
                       mt_rand(0, 0x3fff) | 0x8000, // 48 bits for "node"
                       mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
}
if (!function_exists('setupNewFileName')) {
    /**
     * Function setupNewFileName
     *
     * @param string $prefix
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/17/2021 12:20
     */
    function setupNewFileName($prefix = '')
    {
        if (!empty($prefix)) {
            $prefix = trim($prefix, '-');
            $prefix = $prefix . '-';
        }
        return $prefix . date('Y-m-d') . '-' . generate_uuid_v4();
    }
}