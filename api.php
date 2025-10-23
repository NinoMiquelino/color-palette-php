<?php
// Certifique-se de que a pasta 'uploads/' existe e tem permissão de escrita
// ini_set('display_errors', 1); // Descomente para debug
// error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');


/**
 * Converte um valor de pixel RGB (inteiro) para uma string hexadecimal (ex: #FF00AA).
 * @param int $rgb O valor do pixel retornado por imagecolorat().
 * @return string A cor hexadecimal.
 */
function rgbToHex($rgb) {
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

/**
 * Processa a imagem para encontrar as cores dominantes.
 * @param string $filePath Caminho para a imagem.
 * @return array A paleta de cores em formato hexadecimal.
 */
function extractColorPalette($filePath) {
    // Redimensionar para uma miniatura pequena para processamento rápido (ex: 50x50 pixels)
    $thumbnailSize = 50; 
    
    // 1. Cria a imagem a partir do arquivo
    $imageInfo = getimagesize($filePath);
    $mime = $imageInfo['mime'];
    
    if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
        $img = imagecreatefromjpeg($filePath);
    } elseif ($mime == 'image/png') {
        $img = imagecreatefrompng($filePath);
    } elseif ($mime == 'image/gif') {
        $img = imagecreatefromgif($filePath);
    } else {
        throw new Exception("Formato de imagem não suportado pela GD.");
    }
    
    if (!$img) {
        throw new Exception("Não foi possível carregar a imagem.");
    }

    // 2. Redimensiona a imagem para processamento (cria uma miniatura em memória)
    $originalWidth = imagesx($img);
    $originalHeight = imagesy($img);
    $thumb = imagecreatetruecolor($thumbnailSize, $thumbnailSize);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumbnailSize, $thumbnailSize, $originalWidth, $originalHeight);
    
    // 3. Analisa todos os pixels da miniatura
    $colorCounts = [];
    for ($x = 0; $x < $thumbnailSize; $x++) {
        for ($y = 0; $y < $thumbnailSize; $y++) {
            $rgb = imagecolorat($thumb, $x, $y);
            $hex = rgbToHex($rgb);
            
            // Agrupar cores semelhantes (opcional, mas recomendado para evitar variações leves)
            // Para simplificar, vamos agrupar apenas pela string HEX neste exemplo.
            
            if (!isset($colorCounts[$hex])) {
                $colorCounts[$hex] = 0;
            }
            $colorCounts[$hex]++;
        }
    }
    
    // 4. Libera memória e ordena as cores por frequência
    imagedestroy($img);
    imagedestroy($thumb);
    arsort($colorCounts);
    
    // 5. Retorna as 10 cores mais dominantes
    $dominantColors = array_keys(array_slice($colorCounts, 0, 10));

    // Remove preto e branco puros se forem muito dominantes (pode ser ajustado)
    $finalPalette = array_filter($dominantColors, function($color) {
        return $color != '#000000' && $color != '#ffffff';
    });

    // Garante no máximo 10 cores na paleta final
    return array_slice(array_values($finalPalette), 0, 10);
}


// --- Lógica da API ---

$method = $_SERVER['REQUEST_METHOD'] ?? '';

if ($method === 'POST') {
    
    $result = ['success' => false, 'palette' => [], 'error' => ''];
    $uploadDir = __DIR__ . '/uploads/'; // Pasta 'src/uploads/'

    try {
        if (empty($_FILES['image'])) {
            throw new Exception("Nenhum arquivo de imagem foi enviado.");
        }
        
        $file = $_FILES['image'];
        
        // Verifica se há erro de upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro de upload: Código " . $file['error']);
        }
        
        // Verifica tipo MIME
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Tipo de arquivo não permitido: " . $file['type']);
        }

        // Move o arquivo temporário
        $tempFileName = uniqid('img_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $tempFilePath = $uploadDir . $tempFileName;
        
        if (!move_uploaded_file($file['tmp_name'], $tempFilePath)) {
            throw new Exception("Falha ao mover o arquivo de upload.");
        }

        // Extrai a paleta de cores
        $palette = extractColorPalette($tempFilePath);
        
        $result['success'] = true;
        $result['palette'] = $palette;

        // Limpeza: Apaga o arquivo temporário
        unlink($tempFilePath);

    } catch (Exception $e) {
        http_response_code(400);
        $result['error'] = $e->getMessage();
    } catch (Error $e) {
        // Captura erros de falta de extensão (como a GD)
        http_response_code(500);
        $result['error'] = "Erro interno: Verifique se a extensão GD do PHP está ativada. Detalhe: " . $e->getMessage();
    }

    echo json_encode($result);
    
} elseif ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
}
