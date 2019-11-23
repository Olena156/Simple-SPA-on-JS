<?php

//Указываем в заколовках, что страница возвращает данные в формате JSON
header("Content-type: application/json; charset=utf-8"); 

//Создаём класс, который будем возвращать. В нём всего два свойства - заголовок и тело страницы
class Page
{
	public $title;
	public $body;

	public function __construct($title, $body)
	{
		$this->title = $title;
		$this->body = $body;
	}
}

$articles = //Создаём статьи 
[
	new Page("Article 1", "<p>asdas 1</p> <a href='/Main' class='link link_internal'>Return to main page</a>"),
	new Page("Article 2", "<p>asdas 2</p> <a href='/Main' class='link link_internal'>Return to main page</a>"),
	new Page("Article 3", "<p>asdas 3</p> <a href='/Main' class='link link_internal'>Return to main page</a>"),
	new Page("Article 4", "<p>asdas 4</p> <a href='/Main' class='link link_internal'>Return to main page</a>")
];

//Получаем запрос от клиента
if(isset($_GET["page"]))
{
	$page = $_GET["page"];
}

if(isset($_GET["id"]))
{
	$id = $_GET["id"];
}
else
{
	$id = 0;
}

//Если никакая страница не подойдёт под запрос, то пользователь увидит сообщение, что страница не найдена
$response = new Page("404", "<p>Page not found</p> <a href='/Main' class='link link_internal'>Return to main page</a>");

switch($page) //Выбираем страницы
{
	case "main": //Главная
		$response = new Page("Main", "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p> <a href='/Articles/1' class='link link_internal'>Article 1</a><br><a href='/Articles/2' class='link link_internal'>Article 2</a><br><a href='/Articles/3' class='link link_internal'>Article 3</a><br><a href='/Articles/4' class='link link_internal'>Article 4</a><br>");
		break;

	case "articles": //Статьи
		if($id > 0)
		{
			if(isset($articles[$id - 1]))
			{
				$response= $articles[$id - 1];
			}
		}
		break;
}

die(json_encode($response)); //Возвращаем страницу
?>