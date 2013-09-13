<?php

    require_once 'classes/BauserviceManager.php';
    require_once 'classes/FileManager.php';
    require_once 'classes/excel_reader2.php';
    require_once 'classes/Log.php';

    $fileManager = new FileManager();
    $files = $fileManager->scan('data/promo/',array('xls'));

    foreach ( $files as $file )
    {

        $xls = new Spreadsheet_Excel_Reader ( $file , true , 'windows-1251' );

        for ( $rowKey = 2 ; $rowKey <= $xls->rowcount() ; $rowKey++ )
        {

            $sales = array();
            $itemTitle = $xls->val($rowKey,1);

            for ( $colKey = 2 ; $colKey <= $xls->colcount() ; $colKey++ )
            {
                $sale = $xls->val($rowKey,$colKey);
                if (strlen($sale)>0)
                    $sales[] = array($colKey-1,$sale);
            }

            if ( !empty ($sales) )
            {

                $item = BauserviceManager::getItemByTitle($itemTitle);

                if ($item === false)
                    continue;

                $setSale = BauserviceManager::setItemPromoStatus($item,$sales);

            }

        }

    }

    /*
    $items = BauserviceManager::getItemsByCollection("Saron 32,6х32,6 (Украина)");
    foreach ($items as $item)
        echo $item->id . "<br>";
    */
?>