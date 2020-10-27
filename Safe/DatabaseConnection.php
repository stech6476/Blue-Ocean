<?php $pdo = new PDO('mysql:host=localhost; dbname=;   
		charset = utf8', '', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     //Set maximum error reporting for PDO otherwise debugging will be very difficult
		