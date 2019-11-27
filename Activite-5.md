une erreur est provoquer entre 2 reqètes SQL, la deuxième ne s'execute donc pas (ici pas de log dans la table alors que l'etat de l'utilisateur à changer).
Pour résoudre ce problème, il faudrait les executées dans une même transaction pour garantir que l'on est pas l'une sans l'autre

Aprés avoir regrouper les 2 requètes dans la même transaction, on peut utiliser le rollback si il y erreur et donc	
annuler également la première transaction.  