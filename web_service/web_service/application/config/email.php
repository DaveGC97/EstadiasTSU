<?php

            $config['protocol'] = 'smtp';  // protocolo de envio de correo
            $config['smtp_host'] = 'ssl://smtp.googlemail.com'; // dirección SMTP del servidor                              
            $config['smtp_user'] = 'roger221199@gmail.com'; // remplazarlo por un cuenta real de Gmail - usuario SMTP
            $config['smtp_pass'] = '221199120199'; 
            $config['smtp_port'] = '465'; // o el '587' --  Puerto SMTP 
            $config['smtp_timeout'] = '6';  // Tiempo de espera SMTP(segundos)
            //$config['email']['newline']  = '\r\n';
            $config['mailtype'] = 'html'; // o text para texto sin HTML
?>