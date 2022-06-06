<?php

namespace Services\allClass;

const MIME_TYPES = array(
    // images
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'svg' => 'image/svg+xml',
    // adobe
    'pdf' => 'application/pdf',
);
    
const UPLOADS_DIR = 'public/uploads/';                   // UPLOADS_DIR Répertoire ou seront uploadés les fichiers
const FILE_EXT_IMG = ['jpg','jpeg','gif','png', 'JPG'];            // FILE_EXT_IMG  extensions acceptées pour les images

class Uploads {

 /** Déplace un fichier transmis dans un répertoire du serveur
 * @param $file contenu du tableau $_FILES à l'index du fichier à uploader (tableau)
 * @param $errors la variable devant contenir les erreurs. Passage par référence ;)
 * @param $folder chemin absolue ou relatif où le fichier sera déplacé. Par default UPLOADS_DIR
 * @param $fileExtensions par defaut vaut FILE_EXT_IMG. un tableau d'extensions valident
 * @return array un tableau contenant les erreurs (ou vide) ou un string avec le nom du fichier securisé pour pouvoir travailler dans la base de données..
 *
 */

    public function upload(array $file, string $dossier = '', array &$errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG) {
        $filename = '';

        if ($file["error"] === UPLOAD_ERR_OK) {
            $tmpName = $file["tmp_name"];

            // On récupère l'extension du fichier pour vérifier si elle est dans  $fileExtensions
            $tmpNameArray = explode(".", $file["name"]);
            $tmpExt = end($tmpNameArray);
            if(in_array($tmpExt, $fileExtensions))
            {
                // basename() peut empêcher les attaques de système de fichiers en supprimant les éventuels répertoire dans le nom
                // la validation/assainissement supplémentaire du nom de fichier peut être appropriée
                // On donne un nouveau nom au fichier
                $filename = uniqid().'-'.basename($file["name"]);
                if(!move_uploaded_file($tmpName, $folder.$dossier."/".$filename))
                {
                    $errors[] = 'Le fichier n\'a pas été enregistré correctement';
                }
                // mime_content_type 
                // Détecte le type de contenu d'un fichier. 
                // On vérifie le contenue de fichier, pour voir s'il appartient aux MIMES autorises.
                if(!in_array(mime_content_type($folder.$filename), MIME_TYPES, true)) {
                    // var_dump(mime_content_type($folder.$filename));
                    $errors[] = 'Le fichier n\'a pas été enregistré correctement car il ne correspond pas au MIME indiqué';
                }
            }
            else
                $errors[] = 'Ce type de fichier n\'est pas autorisé !';
        }
        else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
            //fichier trop volumineux
            $errors[] = 'Le fichier est trop volumineux';
        }
        else {
            $errors[] = 'Une erreur a eu lieu au moment de l\'upload';
        }
        return $filename;
    }
}