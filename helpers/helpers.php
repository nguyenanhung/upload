<?php
/**
 * Project upload
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 09/17/2021
 * Time: 17:28
 */
if (!function_exists('setupNewFileName')) {
    /**
     * Function setupNewFileName
     *
     * @param string $prefix
     *
     * @return string
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 18/07/2022 10:34
     */
    function setupNewFileName(string $prefix = ''): string
    {
        if (!empty($prefix)) {
            $prefix = trim($prefix, '-');
            $prefix .= '-';
        }

        return trim($prefix) . date('Y-m-d') . '-' . generate_uuid_v4();
    }
}
