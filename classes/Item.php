<?php

    require_once 'classes/DbManager.php';

    class Item
    {

        public $id;
        private $dbManager;

        public function __construct($name='')
        {

            $this->dbManager = new DbManager('178.159.255.108','noleynikov','XCVeVDm054WYPAtdouGe','new_bauserv');

        }

        public function getIdByTitle($title)
        {

            if ( is_string ( $title ) && ! empty( $title ) )
            {

                //$title = str_replace (array("\n", "\r"), '', $title);
                //$title = trim($title);
                //$title = "Dolce Beige Sliwka Декор 10х10 56шт";

                $query = "  SELECT
                                XML_ID
                            FROM
                                b_iblock_element
                            WHERE
                                (
                                    b_iblock_element.NAME = '$title'
                                        OR
                                    b_iblock_element.PREVIEW_TEXT = '$title'
                                )
                                    AND
                                b_iblock_element.IN_SECTIONS = 'Y'";

//                echo $query;

                $result = $this->dbManager->query($query);

            //    if($result===false || mysqli_num_rows($result)==0)
              //      throw new Exception('Item named <i>"'.$title.'"</i> not found!</span>');

               /* else*/ if(mysqli_num_rows($result)>1)
                    throw new Exception('Item named <i>"'.$title.'"</i> is ambiguous!</span>');

                $result = mysqli_fetch_array($result);
                $this->id = $result['XML_ID'];
                return $this->id;

            }

            else
                throw new Exception ( 'Item title is invalid' );

        }

        public function setSale($sales)
        {
            
            foreach ($sales as $sale)
            {

                $itemId = $this->id;
                $site = $sale[0];
                $sale = $sale[1];
                
                $query = '  UPDATE
                                status_prod
                            SET
                                sale = '.$sale.'
                            WHERE
                                product_uuid = "'.$itemId.'"
                                    AND
                                site = '.$site;

                if( ( is_numeric($sale) && ( $sale==0 || $sale==1 ) ) )
                {

                    if ( is_numeric($site) && $site >= 1)
                    {

                        $text = 'Trying to set sale status of <i>"'.$itemId.'"</i> to <i>"'.$sale.'"</i> on site <i>"'.$site.'"</i>';
                        $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_PROCESSING );
                        Logger::singleton()->push($message);

                        $result = $this->dbManager->query($query);

                        if ($result===false)
                        {
                            $text = 'Couldn`t set sale status of <i>"'.$itemId.'"</i> to <i>"'.$sale.'"</i> on site <i>"'.$site.'"</i>';
                            $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                            Logger::singleton()->push($message);
                            continue;
                        }

                        $message = new LogMessage ( '' , LogMessage::LOG_MESSAGE_TYPE_SUCCESS );
                        Logger::singleton()->push($message);

                    }

                    else
                    {
                        $text = 'Invalid site id: <i>"'.$site.'"</i>';
                        $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                        Logger::singleton()->push($message);
                        continue;
                    }

                }

                else if ( $sale == '' )
                    continue;

                else
                {
                    $text = 'Invalid sale value: <i>"'.$sale.'"</i>';
                    $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                    Logger::singleton()->push($message);
                    continue;
                }

            }
            
        }

        public function setPromo($sales)
        {

            foreach ($sales as $sale)
            {

                $itemId = $this->id;
                $site = $sale[0];
                $sale = $sale[1];

                $query = '  UPDATE
                                status_prod
                            SET
                                action = '.$sale.'
                            WHERE
                                product_uuid = "'.$itemId.'"
                                    AND
                                site = '.$site;

                if( ( is_numeric($sale) && ( $sale==0 || $sale==1 ) ) )
                {

                    if ( is_numeric($site) && $site >= 1)
                    {

                        $text = 'Trying to set promo status of <i>"'.$itemId.'"</i> to <i>"'.$sale.'"</i> on site <i>"'.$site.'"</i>';
                        $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_PROCESSING );
                        Logger::singleton()->push($message);

                        $result = $this->dbManager->query($query);

                        if ($result===false)
                        {
                            $text = 'Couldn`t set sale status of <i>"'.$itemId.'"</i> to <i>"'.$sale.'"</i> on site <i>"'.$site.'"</i>';
                            $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                            Logger::singleton()->push($message);
                            continue;
                        }

                        $message = new LogMessage ( '' , LogMessage::LOG_MESSAGE_TYPE_SUCCESS );
                        Logger::singleton()->push($message);

                    }

                    else
                    {
                        $text = 'Invalid site id: <i>"'.$site.'"</i>';
                        $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                        Logger::singleton()->push($message);
                        continue;
                    }

                }

                else if ( $sale == '' )
                    continue;

                else
                {
                    $text = 'Invalid sale value: <i>"'.$sale.'"</i>';
                    $message = new LogMessage ( $text , LogMessage::LOG_MESSAGE_TYPE_ERROR );
                    Logger::singleton()->push($message);
                    continue;
                }

            }

        }
        
        public function getIssues()
        {

        }

        public function getVisible ( $site )
        {

            $sqlQueryItemVisibleOnSite =    "
                                                SELECT
                                                    status_prod.view
                                                FROM
                                                    status_prod
                                                WHERE
                                                    status_prod.product_uuid = '$this->id'
                                                        AND
                                                    status_prod.site = $site
                                            ";

            $sqlResultItemVisibleOnSite = $this->dbManager->query($sqlQueryItemVisibleOnSite);


            if($sqlResultItemVisibleOnSite===false || mysqli_num_rows($sqlResultItemVisibleOnSite)!=1)
                throw new Exception("Could not get the visibility of item <i>$this->id</i> on site $site.</span>");

            $sqlResultEntryItemVisibleOnSite = mysqli_fetch_array($sqlResultItemVisibleOnSite);
            $visible = $sqlResultEntryItemVisibleOnSite['view'];

            return $visible;

        }

    }
    
?>
