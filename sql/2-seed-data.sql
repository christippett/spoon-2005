-- Mirror 'news' posts from forum on the front-page
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

-- Populate missing plan entry for free tier
INSERT INTO `plans` VALUES (
  0, 'SPOON Free', 0.0, 10, 500, 1, 0, 1, 0, '/images/plan_1.gif'
);

-- Activate hosting for exsting users
UPDATE `users` SET hosting = 1
WHERE realname IS NOT NULL;

-- Add client record for hosted users
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

-- Add dummy account record
INSERT INTO `accounts` (user_id)
SELECT user_id FROM clients;

-- Populate client invoices
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
