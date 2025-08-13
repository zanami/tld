<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

$arTemplate = [
	"NAME" => GetMessage("TAILWIND_TEMPLATE_NAME"),
	"SORT" => 100,
	"DESCRIPTION" => GetMessage("TAILWIND_TEMPLATE_DESCRIPTION"),
];
