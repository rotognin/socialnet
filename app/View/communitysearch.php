<?php

/**
 * Listar comunidades que o usuário ainda não participa (lista simples)
 * - Posteriormente implementar colocando se algum amigo participa dela, colocar paginação, etc
 */

use app\Model as Model;

// Quebrar a cabeça com um SELECT onde apareçam todas as comunidades que um usuário não participa.
// Seguem abaixo os Selects que eu estava tentando no banco:

/*

SELECT u.usuId, u.usuName, u.usuCity, u.usuState, p.parSituation, c.comAdmUser 
FROM users_tb u 
LEFT JOIN participations_tb p ON p.parIdUser = u.usuId 
LEFT JOIN communities_tb c ON p.parIdCommunity = c.comId 
WHERE p.parIdCommunity = 11 AND p.parSituation = 1;

SELECT c.comId, c.comName FROM communities_tb c
LEFT JOIN participations_tb p ON p.parIdCommunity = c.comId
WHERE p.parIdUser = 2 AND
p.parIdUser NOT IN (SELECT parIdUser FROM participations_tb)
-- c.comId <> (SELECT  FROM participations_tb  )
ORDER BY c.comId DESC;

SELECT p.parIdCommunity, c.comName FROM participations_tb p 
LEFT JOIN communities_tb c ON c.comId = p.parIdCommunity
WHERE parIdUser <> 2 GROUP BY p.parIdCommunity, c.comName;

*/


?>