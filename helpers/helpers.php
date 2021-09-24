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
     * @throws \Exception
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 09/24/2021 32:47
     */
    function setupNewFileName(string $prefix = ''): string
    {
        if (!empty($prefix)) {
            $prefix = trim($prefix, '-');
            $prefix .= '-';
        }
        return $prefix . date('Y-m-d') . '-' . generate_uuid_v4();
    }
}