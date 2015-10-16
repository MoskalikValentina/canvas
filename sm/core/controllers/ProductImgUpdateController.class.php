<?php
/**
 * Use for product images update
 */

class ProductImgUpdateController {
    private $config;

    /**
     * @param Config $config Object with config data
     */
    public function __construct(Config $config){
        $this->config = $config;
    }

    //todo Add img files to config and add tmp_img clean
    public function update($file_path){
        //Zip prepare
        require_once BASEDIR . 'sm/core/helpers/ZIP.class.php';
       $file_name = $file_path;
        $zip_directory = '';
        $import_zip = new Zip($file_name, $zip_directory);

        //Unzip
        $import_path = $this->config->import_path();
        @$import_zip->unzip($import_path); //todo sole probleme with warnings without @ use

        //Remove old images
        $pro_img_path = $this->config->prod_img_path();
        if(file_exists ($pro_img_path))
            $this->deleteDir($pro_img_path);

        $this->xcopy($import_path . '/' . $pro_img_path , $pro_img_path);

//        if(file_exists ($import_path . '/' . $pro_img_path))
//            $this->deleteDir($import_path . '/' . $pro_img_path);

    }

    /**
     * Use for delete directory
     * @param $dirPath path to dir for deleting
     */
    function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @param       string   $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    function xcopy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();
        return true;
    }
} 