CREATE TABLE `payments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `item_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `txn_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `payment_gross` float(10,2) NOT NULL,
 `currency_code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
 `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;