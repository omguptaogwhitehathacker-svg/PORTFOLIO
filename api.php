<?php
header('Content-Type: application/json');
$dataFile = 'projects.json';

// Ensure the JSON file exists
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, '[]');
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Send projects to the frontend
    echo file_get_contents($dataFile);
} elseif ($method === 'POST') {
    // Receive new project from frontend
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['title']) && isset($input['description'])) {
        $projects = json_decode(file_get_contents($dataFile), true);
        
        $newProject = [
            'id' => time(), // Use timestamp as a unique ID
            'title' => htmlspecialchars($input['title']),
            'description' => htmlspecialchars($input['description']),
            'tags' => htmlspecialchars($input['tags'])
        ];
        
        array_unshift($projects, $newProject); // Add to the top of the list
        file_put_contents($dataFile, json_encode($projects, JSON_PRETTY_PRINT));
        
        echo json_encode(['status' => 'success', 'project' => $newProject]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
}
?>