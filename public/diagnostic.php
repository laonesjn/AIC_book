<?php
/**
 * Photo Path Diagnostic Script
 * Place this in public/diagnostic.php
 * Visit: http://localhost/diagnostic.php
 */

// Load Laravel
require __DIR__ . '/../bootstrap/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

// Get database connection
$pdo = DB::connection()->getPdo();

// Query committee members
$stmt = $pdo->query("SELECT id, full_name, photo_path, status FROM committee_members");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Photo Path Diagnostic</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        .yes { color: green; font-weight: bold; }
        .no { color: red; font-weight: bold; }
        .code { background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <h1>📸 Photo Path Diagnostic</h1>
    
    <h2>Database Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Photo Path</th>
            <th>Status</th>
            <th>File Exists</th>
            <th>Full Path</th>
        </tr>
        <?php foreach ($members as $member): ?>
            <?php 
                $photoPath = public_path($member['photo_path']);
                $fileExists = file_exists($photoPath);
            ?>
            <tr>
                <td><?php echo $member['id']; ?></td>
                <td><?php echo $member['full_name']; ?></td>
                <td><?php echo $member['photo_path']; ?></td>
                <td><?php echo $member['status']; ?></td>
                <td class="<?php echo $fileExists ? 'yes' : 'no'; ?>">
                    <?php echo $fileExists ? '✓ YES' : '✗ NO'; ?>
                </td>
                <td><?php echo $photoPath; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Directory Contents</h2>
    <div class="code">
        <?php
            $dir = public_path('CommitteeMembers/photo');
            if (is_dir($dir)) {
                $files = scandir($dir);
                echo "Directory: " . $dir . "\n\n";
                echo "Files:\n";
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $fullPath = $dir . '/' . $file;
                        $size = filesize($fullPath);
                        echo "  - " . $file . " (" . $size . " bytes)\n";
                    }
                }
            } else {
                echo "Directory does not exist: " . $dir;
            }
        ?>
    </div>

    <h2>Test Direct URL</h2>
    <p>Try visiting these URLs directly in your browser:</p>
    <ul>
        <?php foreach ($members as $member): ?>
            <li>
                <a href="/<?php echo $member['photo_path']; ?>" target="_blank">
                    /<?php echo $member['photo_path']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Next Steps</h2>
    <ol>
        <li>Check the table above - all should show "✓ YES" in File Exists column</li>
        <li>If showing "✗ NO", the file path is wrong or file doesn't exist</li>
        <li>Click the test URLs above - photos should display</li>
        <li>If photos display in direct URL but not in admin/client pages, it's a view template issue</li>
    </ol>

    <h2>Delete This File</h2>
    <p>After diagnosis, delete this file: <code>public/diagnostic.php</code></p>
</body>
</html>
