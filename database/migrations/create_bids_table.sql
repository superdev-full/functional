CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `notes` text NULL,
  `solution` text NULL,
  `attachment` VARCHAR(255)  NULL,
  `bid_amount` decimal(10,2) DEFAULT 5.00 NULL,
  `applied_at` datetime DEFAULT NULL,
  `retracked_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `selected_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `answered_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
