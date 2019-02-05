<?php

    namespace App\Utils;

    class Emailer
    {
        private $mailer;

        public function __construct( \Swift_Mailer $mailer )
        {
            $this->mailer = $mailer;
        }

        public function sendTimecard( $subject, $setTo, $setFrom, $callback )
        {    
            $message = (new \Swift_Message( $subject ))
            ->setFrom( $setFrom )
            ->setTo( $setTo )
            ->setBody( $callback, "text/html" );

            $this->mailer->send($message);
        }
    }