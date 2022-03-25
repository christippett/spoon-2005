-- Mirror 'news' posts from forum on the front-page
TRUNCATE TABLE `news`;

INSERT INTO `news` (title, body, `timestamp`)
SELECT
  t.subject AS title,
  p.message AS body,
  FROM_UNIXTIME(p.posted) AS `timestamp`
FROM
  `posts` p
INNER JOIN
  `topics` t ON
    p.topic_id = t.id
WHERE
  t.forum_id = 5;


-- Activate hosting for exsting users
UPDATE `users` SET hosting = 1
WHERE realname IS NOT NULL;


-- Add client record for hosted users
TRUNCATE TABLE `clients`;

INSERT INTO `clients` (
  `user_id`, `plan_id`, `type`, `ordered`,
  `domain`, `domain_reg`, `username`, `password`,
  `fname`, `lname`, `address1`, `address2`, `city`, `country`
)
SELECT
  id AS user_id,
  FLOOR((RAND()*3)+1) AS plan_id,
  1 AS `type`,
  UNIX_TIMESTAMP('2006-01-01') AS ordered,
  CONCAT(username, '.spoon.net.nz') AS domain,
  0 AS domain_reg,
  username AS username,
  'pla1nt3xt' AS `password`,
  SUBSTRING_INDEX(realname, ' ', 1) AS fname,
  SUBSTRING_INDEX(realname, ' ', -1)  AS lname,
  '416 Fake Street' AS address1,
  'Takapuna' AS address2,
  SUBSTRING_INDEX(location, ', ', 1)  AS city,
  SUBSTRING_INDEX(location, ', ', -1) AS country
FROM
  `users`
WHERE
  hosting = 1;


-- Add account record for client
TRUNCATE TABLE `accounts`;

INSERT INTO `accounts` (user_id, `type`, domain)
SELECT user_id, 1, domain FROM clients;


-- Setup account as a recurring subscription
TRUNCATE TABLE `recurrings`;

INSERT INTO `recurrings` (user_id, account_id, `type`, domain, active)
SELECT
  user_id,
  id AS account_id,
  `type`,
  domain,
  '1' AS active
FROM
  `accounts`;


-- Populate client invoices
TRUNCATE TABLE `invoices`;

INSERT INTO `invoices` (
  `user_id`, `domain`, `desc`, `total`,
  `issued`, `due`, `fname`, `lname`,
  `address1`, `address2`, `city`, `country`
)
SELECT
  c.user_id,
  c.domain,
  CONCAT('"', p.plan_name, '" hosting for 1-month') AS `desc`,
  p.price AS total,
  c.ordered AS issued,
  c.ordered + 604800 AS due,
  c.fname,
  c.lname,
  c.address1,
  c.address2,
  c.city,
  c.country
FROM
  `clients` c
LEFT JOIN
  `plans` p
  ON c.plan_id = p.id
;
