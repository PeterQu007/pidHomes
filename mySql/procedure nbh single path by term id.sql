CREATE DEFINER=`root`@`localhost` PROCEDURE `procedure_nbh_single_path_by_term_id`(IN term_id bigint(20))
BEGIN
WITH RECURSIVE nbh_path (nbh_term_id, nbh_id, nbh_code, nbh_name, parent) AS
(
SELECT nbh.wp_term_id, nbh.Neighborhood_ID, nbh.Neighborhood_Code, nbh.Neighborhood_Name, nbh.parent
    FROM pid_neighborhoods nbh
    WHERE nbh.wp_term_id = term_id -- @nbh_term_id
UNION ALL
SELECT nbh.wp_term_id, nbh.Neighborhood_ID, nbh.Neighborhood_Code, nbh.Neighborhood_Name, nbh.parent
FROM nbh_path AS np JOIN pid_neighborhoods AS nbh
  ON np.parent = nbh.wp_term_id
)
-- SELECT * FROM nbh_path;
SELECT nbh_level, np.nbh_term_id, np.nbh_id, np.nbh_name, np.nbh_code, t.slug, np.parent
FROM
(SELECT (SELECT count(*) FROM nbh_path) - (ROW_NUMBER() OVER ()) nbh_level, nbh_term_id, nbh_id, nbh_name, nbh_code, parent
FROM nbh_path Order By nbh_level) AS np
INNER JOIN wp_terms t ON t.term_id = np.nbh_term_id
INNER JOIN wp_term_taxonomy wt ON wt.term_id = t.term_id
WHERE wt.taxonomy = 'property-city'
Order by nbh_level ;
END