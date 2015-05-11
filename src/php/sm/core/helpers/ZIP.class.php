<?php

/**
 * Use for zip files and diractories
 */
class Zip
{

   private $zip;
   private $path;

   /**
    * Consrtuct new archive
    * @param string $file_name name of zip archive
    * @param string $zip_directiry name of directory for archive file seving
    */
   public function __construct($file_name, $zip_directory)
   {
        $this->zip = new ZipArchive();
        $this->path = $zip_directory . $file_name;
        //$this->path = $zip_directory . $file_name . '.zip';
        $this->zip->open( $this->path, ZipArchive::CREATE );
    }

   /**
     * Get the absolute path to the zip file
     * @return string
     */
    public function get_zip_path()
    {
        return realpath($this->path);
    }

    /**
     * Add a directory to the zip
     * @param $directory
     */
    public function add_directory( $directory )
    {
        if( is_dir( $directory ) && $handle = opendir( $directory ) )
        {
            $this->zip->addEmptyDir( $directory );
            while( ( $file = readdir( $handle ) ) !== false )
            {
                if (!is_file($directory . '/' . $file))
                {
                    if (!in_array($file, array('.', '..')))
                    {
                        $this->add_directory($directory . '/' . $file );
                    }
                }
                else
                {
                    $this->add_file($directory . '/' . $file);                }
            }
        }
    }

    /**
     * Add a single file to the zip
     * @param string $path
     */
    public function add_file( $path )
    {
        $this->zip->addFile( $path, $path);
    }

    /**
     * Close the zip file
     */
    public function save()
    {
        $this->zip->close();
    }


    // http://php.net/manual/ru/ref.zip.php
    // This is the function I use to unzip a file.
    // It includes the following options:
    // * Unzip in any directory you like
    // * Unzip in the directory of the zip file
    // * Unzip in a directory with the zipfile's name in the directory of the zip file. (i.e.: C:\test.zip will be unzipped in  C:\test\)
    // * Overwrite existing files or not
    // * It creates non existing directories with the function Create_dirs($path)

    // You should use absolute paths with slashes (/) instead of backslashes (\).
    // I tested it with PHP 5.2.0 with php_zip.dll extension loaded


    /**
    * Unzip the source_file in the destination dir
    *
    * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
    * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
    * @param   boolean     Overwrite existing files (true) or not (false)
    *
    * @return  boolean     Succesful or not
    */
    function unzip($dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
    {
       $src_file = $this->path;

      if ($zip = zip_open($src_file))
      {
        if ($zip)
        {
          $splitter = ($create_zip_name_dir === true) ? "." : "/";
          if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";

          // Create the directories to the destination dir if they don't already exist
          $this->create_dirs($dest_dir);

          // For every file in the zip-packet
          while ($zip_entry = zip_read($zip))
          {
            // Now we're going to create the directories in the destination directories

            // If the file is not in the root dir
            $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
            if ($pos_last_slash !== false)
            {
              // Create the directory where the zip-entry should be saved (with a "/" at the end)
              $this->create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
            }

            // Open the entry
            if (zip_entry_open($zip,$zip_entry,"r"))
            {

              // The name of the file to save on the disk
              $file_name = $dest_dir.zip_entry_name($zip_entry);

              // Check if the files should be overwritten or not
              if ($overwrite === true || $overwrite === false && !is_file($file_name))
              {
                // Get the content of the zip entry
                $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                file_put_contents($file_name, $fstream );
                // Set the rights
                chmod($file_name, 0777);
                //echo "save: ".$file_name."<br />";
              }

              // Close the entry
              zip_entry_close($zip_entry);
            }
          }
          // Close the zip-file
          zip_close($zip);
        }
      }
      else
      {
        return false;
      }

      return true;
    }

    /**
    * This function creates recursive directories if it doesn't already exist
    *
    * @param String  The path that should be created
    *
    * @return  void
    */
    function create_dirs($path)
    {
      if (!is_dir($path))
      {
        $directory_path = "";
        $directories = explode("/",$path);
        array_pop($directories);

        foreach($directories as $directory)
        {
          $directory_path .= $directory."/";
          if (!is_dir($directory_path))
          {
            mkdir($directory_path);
            chmod($directory_path, 0777);
          }
        }
      }
    }
}

?>