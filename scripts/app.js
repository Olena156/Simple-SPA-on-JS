var links = null;

const sitename = "http://localhost/spa/";

var data = 
{ 
	title: "", 
	body: "", 
	link: "" 
};

var page = 
{
	title: document.getElementById("title"),
	body: document.getElementById("body")
};


OnLoad();

function SendRequest(query, link)
{
	var xhr = new XMLHttpRequest();

	xhr.open("GET", "/spa/core.php" + query, true);

	xhr.onreadystatechange = function() 
	{ 
		if (xhr.readyState != 4) return;

		if (xhr.status == 200) 
		{

			GetData(JSON.parse(xhr.responseText), link);
		} 
		else 
		{
			console.log(xhr.status + ": " + xhr.statusText);
		}
	}

	xhr.send();
}

function GetData(response, link)
{
	data = 
	{
		title: response.title, 
		body: response.body, 
		link: link 
	};

	UpdatePage();
}

function InitLinks()
{
	links = document.getElementsByClassName("link_internal");

	for (var i = 0; i < links.length; i++) 
	{
		links[i].addEventListener("click", function (e) { e.preventDefault(); LinkClick(e.target.getAttribute("href"));  return false;});
	}
}

function LinkClick(href)
{
	var props = href.split("/");

	switch(props[1])
	{
		case "Main":
			SendRequest("?page=main", href);
			break;

		case "Articles":
			if(props.length == 3 && !isNaN(props[2]) && Number(props[2]) > 0)
			{
				SendRequest("?page=articles&id=" + props[2], href);
			}
			break;
	}
}

function UpdatePage()
{
	page.title.innerText = data.title;
	page.body.innerHTML = data.body;

	document.title = data.title;
	window.history.pushState(data.body, data.title, "/spa" + data.link);

	InitLinks();
}

function OnLoad()
{
	var link = window.location.pathname;

	var href = link.replace("spa/", "");

	if(href.split("/")[1] != "Main")
	{
		LinkClick(href);

		page.body.innerHTML = "Loading...";
	}
	else
	{
		InitLinks();
	}
}