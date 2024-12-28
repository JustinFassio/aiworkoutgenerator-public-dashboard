<?php

/**
 * Script to update namespace references across the codebase
 * Run from theme root: php scripts/update-namespaces.php
 */

$base_dir = dirname(__DIR__);
$namespace_updates = [
    'AthleteDashboard\\Core\\Abstracts' => 'AthleteDashboard\\Dashboard\\Abstracts',
    'AthleteDashboard\\Core\\Feature' => 'AthleteDashboard\\Dashboard\\Contracts\\FeatureInterface',
    'AthleteDashboard\\Core\\Interfaces' => 'AthleteDashboard\\Dashboard\\Contracts',
    'AthleteWorkouts\\Dashboard' => 'AthleteDashboard\\Dashboard'
];

$directories_to_scan = [
    'features',
    'dashboard',
    'tests'
];

function updateFile(string $file, array $updates): void {
    if (!file_exists($file)) {
        return;
    }

    $content = file_get_contents($file);
    if ($content === false) {
        echo "Could not read file: $file\n";
        return;
    }

    $updated_content = $content;
    foreach ($updates as $old => $new) {
        $updated_content = str_replace($old, $new, $updated_content);
    }

    if ($content !== $updated_content) {
        if (file_put_contents($file, $updated_content) !== false) {
            echo "Updated: $file\n";
        } else {
            echo "Failed to update: $file\n";
        }
    }
}

function scanDirectory(string $dir, array $updates): void {
    $files = glob("$dir/*.php");
    foreach ($files as $file) {
        updateFile($file, $updates);
    }

    $subdirs = glob("$dir/*", GLOB_ONLYDIR);
    foreach ($subdirs as $subdir) {
        if (basename($subdir) !== 'vendor' && basename($subdir) !== 'node_modules') {
            scanDirectory($subdir, $updates);
        }
    }
}

// Update files
foreach ($directories_to_scan as $dir) {
    $full_path = "$base_dir/$dir";
    if (is_dir($full_path)) {
        echo "Scanning directory: $dir\n";
        scanDirectory($full_path, $namespace_updates);
    }
}

echo "Namespace updates complete!\n"; 