SELECT * FROM persons;
SELECT * FROM images;
SELECT * FROM person_images;
SELECT * FROM actions;
SELECT * FROM images WHERE id NOT IN (SELECT image_id FROM person_images WHERE person_id = 1);
insert into `actions` (`id`, `type`, `social_network`, `source_path`, `person_id`, `execute_on`) values (1, 'upload_image', '1', 'C:/', 1, '2015-01-01 12:12:12');
insert into `actions` (`id`, `type`, `social_network`, `source_path`, `person_id`, `execute_on`) values (1, 'post_link', '1', 'C:/', 1, '2015-01-01 18:12:12');

SELECT NOW();
select DATE_SUB(NOW(), INTERVAL 1 HOUR);

SELECT count(*) FROM songs WHERE lyrics is null;