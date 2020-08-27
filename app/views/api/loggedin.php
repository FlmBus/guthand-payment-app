<?php

die(json_encode([
    'success' => true,
    'errors' => [],
    'data' => [
        'logged_in' => $_SESSION['logged_in'] ?? null != null,
    ],
]));
