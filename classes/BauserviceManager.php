<?php

    require_once 'classes/Item.php';
    
    class BauserviceManager
    {

        public static function getItemByTitle ( $itemTitle )
        {

            $text = 'Looking for an item named <i>' . $itemTitle . '</i>';
            $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_PROCESSING );
            Logger::singleton()->push($message);

            $item = new Item();

            try
            {

                $item->getIdByTitle($itemTitle);

            }

            catch(Exception $exception)
            {

                $message = new LogMessage ( $exception->getMessage() , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                Logger::singleton()->push($message);
                return false;

            }

            $message = new LogMessage ( '' , LogMessage::LOG_MESSAGE_TYPE_SUCCESS );
            Logger::singleton()->push($message);

            return $item;
            
        }

        public static function getItemsByCollection ( $collectionName )
        {

            //  Selecting all items with specific collection name
            $sqlQueryGetItemsByCollectionName = "   SELECT DISTINCT
                                                        ad_search.xmlid
                                                    FROM
                                                        ad_search
                                                    WHERE
                                                        ad_search.collection IN
                                                        (
                                                            SELECT
                                                                ad_collection.collection_text
                                                            FROM
                                                                ad_collection
                                                            WHERE
                                                                ad_collection.collection_name = '$collectionName'
                                                        )
                                                ";
            
            $dbManager = new DbManager('188.127.225.132','noleynikov','XCVeVDm054WYPAtdouGe','new_bauserv');
            $sqlQueryResultAllItemsByCollection = $dbManager->query($sqlQueryGetItemsByCollectionName);

            $items = array();

            while ( $itemResult = mysqli_fetch_array($sqlQueryResultAllItemsByCollection,MYSQLI_ASSOC))
            {

                $item = new Item();
                $item->id = $itemResult['xmlid'];
                $items[] = $item;

            }

            return $items;

        }

        public static function setItemSaleStatus ( $item , $sales )
        {

            try
            {

                $item->setSale($sales);

            }

            catch(Exception $exception)
            {

                $message = new LogMessage ( $exception->getMessage() , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                Logger::singleton()->push($message);
                return false;

            }

        }

        public static function setItemPromoStatus ( $item , $sales )
        {

            try
            {

                $item->setPromo($sales);

            }

            catch(Exception $exception)
            {

                $message = new LogMessage ( $exception->getMessage() , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                Logger::singleton()->push($message);
                return false;

            }

        }

        public static function getItemIssues ( $item )
        {

            $text = 'Looking for inssues of the item <i>' . $item->id . '</i>';
            $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_PROCESSING);
            Logger::singleton()->push($message);

            //  printing issues

            


        }

        public static function checkItemVisibility ( Item $item , $visibility )
        {

            foreach ($visibility as $visibilityEntry)
            {

                try
                {

                    $site = $visibilityEntry['site'];
                    $itemVisible = $item->getVisible($site);

                    if ( $itemVisible != $visibilityEntry['visible'] )
                    {

                        $message = new LogMessage ( "Item visibility doesn't match input data on site $site" , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                        Logger::singleton()->push($message);

                    }

                    else
                    {

                        $message = new LogMessage ( "Item visibility matches input data on site $site" , LogMessage::LOG_MESSAGE_TYPE_SUCCESS );
                        Logger::singleton()->push($message);

                    }

                }

                catch(Exception $exception)
                {

                    $message = new LogMessage ( $exception->getMessage() , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                    Logger::singleton()->push($message);

                }

            }

            
        }

        public static function getItemQuantity ( $itemId , $sites )
        {

            if (is_array($itemId) === FALSE)
                $itemId = array($itemId);

            $resWh = $GLOBALS['DB']->Query('
                                            SELECT
                                                *
                                            FROM
                                                bauzakaz.warehouses wh
                                            WHERE
                                                wh.site IN ("' . implode('", "', $sites) . '");
                                        ');

            $arrWh = array();
            while($dataWh = $resWh->Fetch()){
                $arrWh[ $dataWh['XML_ID'] ] = $dataWh;
            }

            $balance = array();
            if (count($arrWh) > 0){
                $resBal = $GLOBALS['DB']->Query(
                                       'SELECT
                                            bal.ballance as QUANTITY,
                                            bal.time_update as TIMESTAMP_X,
                                            bal.XML_ID_prod,
                                            bal.XML_ID_wh
                                        FROM
                                            bauzakaz.ballance1C bal
                                        WHERE
                                            bal.XML_ID_wh IN ("' . implode('", "', array_keys($arrWh)) . '")
                                            AND bal.XML_ID_prod IN ("' . implode('", "', $itemId) . '")
                                        ');


                while($dataBal = $resBal->Fetch()){
                    $dataBal['wh'] = $arrWh[ $dataBal['XML_ID_wh'] ];

                    // указываем данный склад является основным для данного сайта или нет
                    $key = ($dataBal['wh']['site'] == $_SESSION['_SITE_INFO']['ID'])? 'this' : 'other';

                    if ($dataBal['QUANTITY'] < 0)
                        $dataBal['QUANTITY'] = 0;

                    // все данные по складам
                    $balance[ $dataBal['XML_ID_prod'] ]['detail'][ $key ]['wh'][] = $dataBal;
                    // общее количество товара на основном\других складах
                    $balance[ $dataBal['XML_ID_prod'] ]['detail'][ $key ]['all_quant'] += $dataBal['QUANTITY'];
                    // общее кол-во товара на всех интересующих складах
                    $balance[ $dataBal['XML_ID_prod'] ]['all_quant'] += $dataBal['QUANTITY'];
                }

                foreach($balance as &$dataBal)
                {
                    // если на основном складе нет товара, но есть на других складах, то такой товар можно купить по предоплате
                    $dataBal['only_prepay'] = ($dataBal['detail']['this']['all_quant'] == 0 && isset($dataBal['detail']['other']) && $dataBal['detail']['other']['all_quant'] > 0 );
                }
            }

            return $balance;
        }

    }
    
?>
