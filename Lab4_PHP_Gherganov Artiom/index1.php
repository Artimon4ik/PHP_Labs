<?php
// Папка с изображениями
$dir = 'image/';
$files = scandir($dir);

if ($files === false) {
    echo "Папка с изображениями не найдена!";
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Галерея</title>

   <style>
.gallery {
    display: grid;
    grid-template-columns: repeat(5, 1fr); 
    gap: 12px;                             
    max-width: 1200px;                     
    margin: 0 auto;                        
}

.gallery img {
    width: 100%;            
    height: 120px;          
    object-fit: cover;      
    border: 1px solid #ccc;
    border-radius: 4px;     
}
footer p {
    text-align: center;   
    font-size: 14px;      
    margin: 10px 0;       
}
    </style>
</head>

<body>

<header>
    <h1>Галерея</h1>
    <p>#flags</p>
</header>

<main>
    <div class="gallery">
        <?php
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $path = $dir . $file;
                echo '<img src="' . $path . '" alt="image">';
            }
        }
        ?>
    </div>
</main>

<footer>
    <p>USM © Gherganov Artiom</p>
</footer>

</body>
</html>