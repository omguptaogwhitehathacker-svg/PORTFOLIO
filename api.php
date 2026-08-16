<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$dataFile = __DIR__ . '/projects.json';
$adminPasswordHash = hash('sha256', 'admin2026');

if (!file_exists($dataFile)) {
    file_put_contents($dataFile, '[]');
}

function sendJson($payload, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

function getProjects() {
    global $dataFile;
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function saveProjects($projects) {
    global $dataFile;
    file_put_contents($dataFile, json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['auth'])) {
        sendJson(['authenticated' => !empty($_SESSION['admin_logged_in'])]);
    }

    sendJson(getProjects());
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $input = is_array($input) ? $input : [];

    if (($input['action'] ?? null) === 'login') {
        $password = trim((string)($input['password'] ?? ''));
        $submittedHash = hash('sha256', $password);

        if ($submittedHash === $adminPasswordHash) {
            $_SESSION['admin_logged_in'] = true;
            sendJson(['status' => 'success', 'authenticated' => true]);
        }

        sendJson(['status' => 'error', 'message' => 'Invalid password'], 401);
    }

    if (($input['action'] ?? null) === 'logout') {
        session_unset();
        session_destroy();
        sendJson(['status' => 'success']);
    }

    if (empty($_SESSION['admin_logged_in'])) {
        sendJson(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    if (empty($input['title']) || empty($input['description'])) {
        sendJson(['status' => 'error', 'message' => 'Title and description are required'], 400);
    }

    $projects = getProjects();
    $newProject = [
        'id' => (string)time() . '-' . random_int(1000, 9999),
        'title' => trim(strip_tags($input['title'])),
        'description' => trim(strip_tags($input['description'])),
        'tags' => trim(strip_tags((string)($input['tags'] ?? '')))
    ];

    array_unshift($projects, $newProject);
    saveProjects($projects);
    sendJson(['status' => 'success', 'project' => $newProject], 201);
}

if ($method === 'PUT') {
    if (empty($_SESSION['admin_logged_in'])) {
        sendJson(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $input = is_array($input) ? $input : [];

    $projectId = $input['id'] ?? null;
    if ($projectId === null || empty($input['title']) || empty($input['description'])) {
        sendJson(['status' => 'error', 'message' => 'Missing project fields'], 400);
    }

    $projects = getProjects();
    $updated = false;

    foreach ($projects as &$project) {
        if ((string)($project['id'] ?? '') === (string)$projectId) {
            $project['title'] = trim(strip_tags($input['title']));
            $project['description'] = trim(strip_tags($input['description']));
            $project['tags'] = trim(strip_tags((string)($input['tags'] ?? $project['tags'])));
            $updated = true;
            break;
        }
    }
    unset($project);

    if (!$updated) {
        sendJson(['status' => 'error', 'message' => 'Project not found'], 404);
    }

    saveProjects($projects);
    sendJson([
        'status' => 'success',
        'project' => [
            'id' => $projectId,
            'title' => trim(strip_tags($input['title'])),
            'description' => trim(strip_tags($input['description'])),
            'tags' => trim(strip_tags((string)($input['tags'] ?? '')))
        ]
    ]);
}

if ($method === 'DELETE') {
    if (empty($_SESSION['admin_logged_in'])) {
        sendJson(['status' => 'error', 'message' => 'Unauthorized'], 401);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $input = is_array($input) ? $input : [];

    $projectId = $input['id'] ?? null;
    if ($projectId === null) {
        sendJson(['status' => 'error', 'message' => 'Project id is required'], 400);
    }

    $projects = getProjects();
    $filtered = array_values(array_filter($projects, function ($project) use ($projectId) {
        return (string)($project['id'] ?? '') !== (string)$projectId;
    }));

    if (count($filtered) === count($projects)) {
        sendJson(['status' => 'error', 'message' => 'Project not found'], 404);
    }

    saveProjects($filtered);
    sendJson(['status' => 'success', 'deletedId' => $projectId]);
}

sendJson(['status' => 'error', 'message' => 'Method not allowed'], 405);
?>