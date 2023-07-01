<?php

function findDuplicatePhotos($directory)
{
    $fileHashes = array();
    $duplicates = array();

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $filePath = $file->getPathname();
            $fileHash = md5_file($filePath);

            if (isset($fileHashes[$fileHash])) {
                $duplicates[] = array($filePath, $fileHashes[$fileHash]);
            } else {
                $fileHashes[$fileHash] = $filePath;
            }
        }
    }

    return $duplicates;
}

// Usage example
$directory = 'img/';
$duplicates = findDuplicatePhotos($directory);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Duplicate Photos</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid black;
        }
        .thumbnail {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>
<body>
    <?php if (count($duplicates) > 0): ?>
        <h1>Duplicate Photos Found</h1>
        <table>
            <thead>
                <tr>
                    <th>Duplicate 1</th>
                    <th>Duplicate 2</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($duplicates as $duplicate): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $duplicate[0]; ?>" alt="Duplicate 1" class="thumbnail">
                        </td>
                        <td>
                            <img src="<?php echo $duplicate[1]; ?>" alt="Duplicate 2" class="thumbnail">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h1>No Duplicate Photos Found</h1>
    <?php endif; ?>
</body>
</html>
