<?php

/**
 * Class FileLoader Used for help with downloading and uploading files
 */

class FileLoader {

    public function file_force_download($full_file_path) {
        if (file_exists($full_file_path)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($full_file_path));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($full_file_path));
            // читаем файл и отправляем его пользователю
            if ($fd = fopen($full_file_path, 'rb')) {
                while (!feof($fd)) {
                    print fread($fd, 1024);
                }
                fclose($fd);

                //File deleting
                unlink($full_file_path);
                return true;
            }
        }
        return false;

    }
} 