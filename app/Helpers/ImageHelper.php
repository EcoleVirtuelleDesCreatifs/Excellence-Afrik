<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Génère l'URL complète d'une image selon l'environnement
     */
    public static function getImageUrl($imagePath, $default = 'assets/default/image_default.jpg')
    {
        if (empty($imagePath)) {
            return asset($default);
        }

        // En production, les images sont dans public/uploads
        if (app()->environment('production')) {
            // Si le chemin commence déjà par 'uploads/', l'utiliser tel quel
            if (str_starts_with($imagePath, 'uploads/')) {
                return asset($imagePath);
            }
            // Sinon, ajouter le préfixe uploads/
            return asset('uploads/' . $imagePath);
        }

        // En local, utiliser storage/
        return asset('storage/' . $imagePath);
    }

    /**
     * Vérifie si une image existe
     */
    public static function imageExists($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        if (app()->environment('production')) {
            $path = str_starts_with($imagePath, 'uploads/')
                ? public_path($imagePath)
                : public_path('uploads/' . $imagePath);
        } else {
            $path = public_path('storage/' . $imagePath);
        }

        return file_exists($path);
    }

    /**
     * Génère l'URL de la miniature
     */
    public static function getThumbnailUrl($imagePath, $default = 'assets/default/image_default.jpg')
    {
        if (empty($imagePath)) {
            return asset($default);
        }

        // Générer le chemin de la miniature
        $thumbnailPath = str_replace('.', '_thumb.', $imagePath);

        return self::getImageUrl($thumbnailPath, $default);
    }
}