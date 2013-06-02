<?php
require_once("inc/template.inc.php");
$template = new Template;
$template->setTemplateFile("base");

$vars = array(
        "title"           => "<3 From Index with Base. <3",
        "content"         => "this is not lorem ipsums, so there self."
        );

$template->setVariables($vars);
$template->setVariableFromTemplate("fromFile", "inc/stores/lorem.php");
$template->setVariableFromTemplate("nav", "inc/stores/nav.php");
$template->render();