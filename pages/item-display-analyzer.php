<?php

if (0)
{
    require_once 'classes/BauserviceManager.php';
    require_once 'classes/FileManager.php';
    require_once 'classes/excel_reader2.php';
    require_once 'classes/Log.php';

    $fileManager = new FileManager();
    $files = $fileManager->scan('data/item-display-analyzer/',array('xls'));

    foreach ($files as $file)
    {

        $xls = new Spreadsheet_Excel_Reader($file,true,'windows-1251');

        for ( $rowKey = 1 ; $rowKey <= $xls->rowcount() ; $rowKey++ )
        {

            $itemTitle = $xls->val($rowKey,1);

            $item = BauserviceManager::getItemByTitle($itemTitle);

            if ($item === false)
                continue;

            BauserviceManager::getItemIssues($item);
            
        }

    }

}

?>