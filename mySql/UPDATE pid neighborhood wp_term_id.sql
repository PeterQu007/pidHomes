UPDATE pid_neighborhoods, (Select t.term_id , t.name, taxo.parent
from wp_terms t
INNER JOIN wp_term_taxonomy taxo ON t.term_id = taxo.term_id
WHERE taxo.taxonomy = 'property-city') AS term

SET pid_neighborhoods.wp_term_id = term.term_id, pid_neighborhoods.parent = term.parent
WHERE pid_neighborhoods.neighborhood_name = term.name;

-- Assisstant Zone
Select t.term_id , t.name, taxo.parent
from wp_terms t
INNER JOIN wp_term_taxonomy taxo ON t.term_id = taxo.term_id
WHERE taxo.taxonomy = 'property-city' 
