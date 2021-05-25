<?php

    function getWebDomain()
    {
        $protocol = "http://";
        if(isset($_SERVER['HTTPS']))
        {
            if ($_SERVER['HTTPS'] == "on")
            {
                $protocol = "https://";
            }
        }

        $WebDomain = $_SERVER['SERVER_NAME'];

        return $protocol.$WebDomain.'/';
    }

	function getFileName()
	{
		//Devuelve el nombre del archivo
		$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-0);
		return $basename;
	}

	function getServerPath()
	{
		//Devuelve la ruta del archivo dentro del servidor
		$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF'])));
		return realpath($basename);
	}

	function getBrowserUrl(){
		//Devuelve la URL de acceso en el navegador
		//$url= "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'];
		$url= "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		$url= str_replace(':443', '', $url);
		$url = getWebDomain().substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI']));
		return $url;
	}

	function getPageTitle($url) 
	{
		$data = file_get_contents($url);
		$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
    	return $title;
	}


	function getKeyCode($longitud)
	{
		$caracteres = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$key_value = "";
		for ($x = 0; $x <= $longitud; $x++)
		{
			$rand = rand(1, strlen($caracteres));
			$key_value .= substr($caracteres, $rand, 1);
		}
		return $key_value;
	}

    function sendCustomError404()
    {
        http_response_code(404);
        header("HTTP/1.0 404 Not Found");
        include('../404.php');
        die;
    }

    function sendCustomError403()
    {
        http_response_code(403);
        header("HTTP/1.1 403 Forbidden");
        include('../403.php');
        die;
    }