
USE db_name;

CREATE TABLE `memory_statistics` (
  `id` int(11) NOT NULL,
  `player` varchar(255) NOT NULL,
  `score` time NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `memory_statistics`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `memory_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;
