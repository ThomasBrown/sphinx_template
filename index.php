<?php
include 'template.inc.php';

Template::factory( 'message', array('message' => 'test message', 'title' => 'Some nice title' ) )
    ->setVariableFromTemplate('header', 'inc/tpl/header.php', TRUE)->render();