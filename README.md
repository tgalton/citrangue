# citrangue


Choix techniques
    AllClass
        Certaines classes n'ont pas été intégrées aux modèles de la structures MVC. Il s'agit 
        de classes faisant partie intégrante du "framework" personnel utilisé pour ce projet mais
        directement réutilisables ailleurs.
        Ainsi les classes Registratorus (inscription), UserConnectatorus (connexion), PathsFinder (router), DataFinder (données utilisateur courantes) ne font pas partie du MVC.
        
    Choix de sécurité 
        MDP
            Conformément aux recommandations de la CNIL : https://www.cnil.fr/fr/securite-chiffrer-garantir-lintegrite-ou-signer
            Nous utilisons BCRYPT comme algorythme de hachage, il génère lui-même son hachage.
            Le mot de passe (mdp ou pwd) n'est pas spécifiquement indiqué comme faux lorsque l'utilisateur se trompe.
