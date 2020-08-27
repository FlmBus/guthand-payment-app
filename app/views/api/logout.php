<?php

unset($_SESSION['logged_in']);

die(json_encode([
    'success' => true,
    'errors' => [],
    'data' => null,
]));
