/* Select candidate_job date period */
SELECT created_date, name FROM candidate_job WHERE created_date BETWEEN '2010-01-01 00:00:00' AND '2013-12-31 23:59:59';

/* Update candidate_job is_outdated to 1 on date period */
UPDATE candidate_job SET is_outdated = 1 WHERE created_date BETWEEN '2010-01-01 00:00:00' AND '2013-12-31 23:59:59';

/* Replace candidate_job is_outdated to 0 where null */
UPDATE candidate_job SET is_outdated = 0 WHERE is_outdated = '[Null]';