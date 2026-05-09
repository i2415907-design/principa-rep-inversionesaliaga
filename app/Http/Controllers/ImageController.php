<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Servir imágenes de productos desde cualquier ubicación
     */
    public function serveProductImage($filename)
    {
        try {
            // 🔥 BUSCAR EN MÚLTIPLES UBICACIONES
            $possiblePaths = [
                storage_path('app/public/productos/' . $filename),
                public_path('storage/productos/' . $filename),
                public_path('images/productos/' . $filename),
                storage_path('app/public/' . $filename),
                public_path('storage/' . $filename),
            ];
            
            $imagePath = null;
            
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $imagePath = $path;
                    Log::info("✅ Imagen encontrada en: " . $path);
                    break;
                }
            }
            
            if (!$imagePath) {
                Log::error("❌ Imagen no encontrada: " . $filename);
                // Devolver imagen placeholder
                return $this->servePlaceholder();
            }
            
            // Obtener tipo MIME
            $mime = mime_content_type($imagePath);
            if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                return $this->servePlaceholder();
            }
            
            // Servir la imagen
            $fileContents = file_get_contents($imagePath);
            
            return response($fileContents, 200)
                ->header('Content-Type', $mime)
                ->header('Cache-Control', 'public, max-age=2592000') // 30 días
                ->header('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
                
        } catch (\Exception $e) {
            Log::error('Error sirviendo imagen: ' . $e->getMessage());
            return $this->servePlaceholder();
        }
    }
    
    /**
     * Servir imagen placeholder cuando no se encuentre la original
     */
    private function servePlaceholder()
    {
        $placeholder = imagecreate(300, 200);
        $backgroundColor = imagecolorallocate($placeholder, 240, 240, 240);
        $textColor = imagecolorallocate($placeholder, 150, 150, 150);
        
        imagefill($placeholder, 0, 0, $backgroundColor);
        imagestring($placeholder, 5, 80, 90, 'Imagen no disponible', $textColor);
        
        ob_start();
        imagepng($placeholder);
        $imageData = ob_get_clean();
        imagedestroy($placeholder);
        
        return response($imageData, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-cache');
    }
}