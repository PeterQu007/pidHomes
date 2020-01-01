-- Find nbh single path by term id
SET @nbh_term_id = 74; -- 'F30A';
WITH nbh_path (nbh_level, nbh_term_id, nbh_id, nbh_code, nbh_name, parent) AS
(
SELECT 0 nbh_level, nbh.wp_term_id, nbh.Neighborhood_ID, nbh.Neighborhood_Code, nbh.Neighborhood_Name, nbh.parent
    FROM pid_neighborhoods nbh
    WHERE nbh.wp_term_id = @nbh_term_id -- @parent id
UNION ALL
SELECT 1 nbh_level, nbh.wp_term_id, nbh.Neighborhood_ID, nbh.Neighborhood_Code, nbh.Neighborhood_Name, nbh.parent
FROM pid_neighborhoods AS np JOIN pid_neighborhoods AS nbh
  ON np.wp_term_id = nbh.parent
  WHERE np.wp_term_id = @nbh_term_id
)
-- SELECT * FROM nbh_path;
SELECT (ROW_NUMBER() OVER ()) nbh_no, nbh_level, np.nbh_term_id, np.nbh_id, np.nbh_name, np.nbh_code, t.slug, np.parent
FROM
(SELECT nbh_level, nbh_term_id, nbh_id, nbh_name, nbh_code, parent
FROM nbh_path Order By nbh_level) AS np
INNER JOIN wp_terms t ON t.term_id = np.nbh_term_id
INNER JOIN wp_term_taxonomy wt ON wt.term_id = t.term_id
WHERE wt.taxonomy = 'property-city'
Order by nbh_level , t.slug;

-- Assistant Zone

call procedure_nbh_single_path_by_term_id(86);

SET @nbh_id = 565; -- 'F30A';
Select * From pid_neighborhoods
Where neighborhood_id = @nbh_id;

Select t.term_id , t.name
from wp_terms t
INNER JOIN wp_term_taxonomy taxo ON t.term_id = taxo.term_id
WHERE taxo.taxonomy = 'property-city' AND
t.name = 'Burnaby North'