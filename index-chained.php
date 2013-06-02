<?php
require_once("inc/template.inc.php");

Template::factory( 'base', array(
        "title" => "<3 From Index with Base. <3",
        "content" => "this is not lorem ipsums, so there self."
    ))
    ->setVariablesFromTemplates(
        array(
            "fromFile" => "inc/stores/lorem.php",
            "nav" => "inc/stores/nav.php"
        )
    )
    ->render();