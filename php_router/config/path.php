<?php
const ALLOWED_PATHS = [
    'account' => 'AccountController',
    'contact' => 'ContactController',
    'home' => 'HomeController',
    // 'user' => 'UserController',
    'question_editor' => 'QuestionEditorController',
    'subscription' => 'RegistrationController'
];

const DEFAULT_PATH = 'home';
const BASE_CONTROLLER = 'controllers/';