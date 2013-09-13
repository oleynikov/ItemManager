<?php

    class LogMessage
    {

        const LOG_MESSAGE_TYPE_INFO         = 0;
        const LOG_MESSAGE_TYPE_ERROR        = 1;
        const LOG_MESSAGE_TYPE_SUCCESS      = 2;
        const LOG_MESSAGE_TYPE_PROCESSING   = 3;
        
        private $text;
        private $type;

        public function __construct ( $text = '' , $type = 0 )
        {
            
            $this->text = $text;
            $this->type = $type;

        }

        public function getType()
        {

            return $this->type;

        }

        public function getText()
        {

            return $this->text;

        }

    }

    class Logger
    {

        private static $instance = null;
        private $message = null;
        private $timestamps = true;
        private $endOfLine = '<br>';
        
        public static function singleton ()
        {

            if ( is_null ( self::$instance ) )
                self::$instance = new Logger();

            return self::$instance;
            
        }
        
        public function setTimestamps ( $timestamps )
        {
            
            $this->timestamps = $timestamps;
            
        }

        public function setEndOfLine ( $endOfLine = '' )
        {

            $this->endOfLine = $endOfLine;

        }

        public function setMessage ( LogMessage $message = null )
        {

            $this->message = $message;

        }

        public function push (LogMessage $message = null )
        {

            $this->setMessage($message);
            
            $time = $this->getTimestamp();
            $prefix = $this->getPrefix ();
            $text = $this->message->getText();

            echo $prefix . $time . $text . $this->endOfLine;

            ob_flush();
            flush();

        }

        private function getTimestamp ()
        {

            return $this->timestamps
                    ?
                        '[' . date( 'Y/m/d H:i:s' , time() ) .  '] '
                    :
                        '';
            
        }

        private function getPrefix ()
        {

            switch ( $this->message->getType() )
            {

                case LogMessage::LOG_MESSAGE_TYPE_INFO:
                    return '<span class="info">[INFO]</span> ';

                case LogMessage::LOG_MESSAGE_TYPE_PROCESSING:
                    return '<span class="processing">[PROCESSING]</span> ';

                case LogMessage::LOG_MESSAGE_TYPE_ERROR:
                    return '<span class="error">[ERROR]</span> ';

                case LogMessage::LOG_MESSAGE_TYPE_SUCCESS:
                    return '<span class="success">[SUCCESS]</span> ';

                default:
                    return '';

            }

        }

        private function __construct ()
        {

        }

        private function __clone ()
        {

        }

        private function __wakeup()
        {
            
        }

    }

?>
