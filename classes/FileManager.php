<?php

    class FileManager
    {

        public $root;
        
        public function __construct($root='')
        {

            if ($root==='')
                $this->root = preg_replace( '#\?.*$#' , 'data/', $_SERVER['DOCUMENT_ROOT'].$_SERVER["REQUEST_URI"] );

            else
                $this->root = $root;

        }

        public function scan($path='',$filter='')
        {

            $path = $path!=='' ? $path : $this->root;

            $files = array();
            $folder = opendir($path);

            if ( $folder !== false )
            {

                while (false !== ($file = readdir($folder)))
                {

                    if ($file!='.' && $file!='..' )
                    {

                        $filterPass = false;

                        foreach ($filter as $filterItem)
                        {
                            if ( preg_match("#\.$filterItem$#",$file) > 0 )
                            {
                                $filterPass = true;
                                break;
                            }
                        }

                        if ($filterPass)
                        {

                            $fileName = $path.$file;

                            if(is_dir($fileName))
                                $files = array_merge($files,$this->scan("$fileName/"));

                            else
                                $files[] = $fileName;

                        }

                    }

                }

            }
            
            return $files;
            
        }

    }

?>
