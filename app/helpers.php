<?php

if (!function_exists('imageUrl')) {
    /**
     * Génère l'URL complète d'une image selon l'environnement
     */
    function imageUrl($imagePath, $default = 'assets/default/image_default.jpg')
    {
        if (empty($imagePath)) {
            return asset($default);
        }

        // En production, les images sont dans uploads/
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
}

if (!function_exists('imageExists')) {
    /**
     * Vérifie si une image existe
     */
    function imageExists($imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        if (app()->environment('production')) {
            $path = str_starts_with($imagePath, 'uploads/')
                ? base_path($imagePath)
                : base_path('uploads/' . $imagePath);
        } else {
            $path = public_path('storage/' . $imagePath);
        }

        return file_exists($path);
    }
}

if (!function_exists('thumbnailUrl')) {
    /**
     * Génère l'URL de la miniature
     */
    function thumbnailUrl($imagePath, $default = 'assets/default/image_default.jpg')
    {
        if (empty($imagePath)) {
            return asset($default);
        }

        // Générer le chemin de la miniature
        $thumbnailPath = str_replace('.', '_thumb.', $imagePath);

        return imageUrl($thumbnailPath, $default);
    }
}