<?php

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @throws SyntaxError
 * @throws RuntimeError
 * @throws LoaderError
 */
function view($template, $data = []): string
{
	global $twig;
	
	return $twig->render($template, $data);
}
