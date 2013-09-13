<?php

    require_once 'classes/BauserviceManager.php';
    require_once 'classes/FileManager.php';
    require_once 'classes/excel_reader2.php';
    require_once 'classes/Log.php';

    

    $fileManager = new FileManager();
    $files = $fileManager->scan('data/visibility/',array('xls'));

    foreach ( $files as $file )
    {

        $xls = new Spreadsheet_Excel_Reader ( $file , true , 'windows-1251' );

        for ( $rowKey = 2 ; $rowKey <= $xls->rowcount() ; $rowKey++ )
        {

            $visibility = array();

            for ( $colKey = 2 ; $colKey <= $xls->colcount() ; $colKey++ )
            {
                $visible = $xls->val($rowKey,$colKey);
                
                if (strlen($visible)>0)
                {

                    $visibility[] = array
                    (
                        'site'      => $colKey-1,
                        'visible'   => $visible
                    );

                }
                
            }

            if ( ! empty ( $visibility ) )
            {

                $itemTitle = $xls->val($rowKey,1);
                $item = BauserviceManager::getItemByTitle($itemTitle);

                if ($item === false)
                    continue;
                
                BauserviceManager::checkItemVisibility($item,$visibility);

            }

        }

    }

?>