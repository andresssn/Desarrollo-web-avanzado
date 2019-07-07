<?php 
ob_start();
 if( isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['password']) && $_POST['password'] != "" ){
	$user = str_replace(" ", "", $_POST['user']);
    $password = str_replace(" ", "", $_POST['password']);
	echo "<pre> <br>";
	echo "<b>user: {$user}</b>";
	//echo "<pre>";
	//echo "pass: {$password}";
	echo "<pre>";
	echo("<button onclick=\"location.href='index.php'\">Logout</button>");
    echo "<pre>";
	$dir_path_img= "images/";
	$dir_path_files= "files/";
	$users[]=""; //arreglo para guardar usuario y password
	$csv = array();

	//lectura de usuarios
	if(is_dir($dir_path_files))
	{
		$file=fopen($dir_path_files."usuarios.txt", "r");
		$indice=0;
		while(!feof($file)){
			$linea=fgets($file); //saca un string de linea del archivo
			$arreglo=explode(",",trim($linea)); //convierte la linea string en un arreglo
			$users[$indice]=$arreglo; //donde [indice][usuario,pass]
			$indice++;
			//echo "<pre>";
			//var_dump($users); //muestra el tipo y contenido de una variable
		}
            if(($user == $users[0][0]) && ($password == $users[0][1]) ){
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['password'] = $password;
                $_SESSION['id_session'] = session_id();
				echo "<pre>";
            }
	    else{
				header('location:index.php');
				exit();
	    }
	}
	else die("<b>no hay directorio: ".$dir_path_files."</b>");
	fclose($file);
	
	//lectura de info de las monedas en un arreglo
	if(is_dir($dir_path_files))
	{
		$info = fopen($dir_path_files."monedas.csv", 'r');
		while (($result = fgetcsv($info,100,";")) !== false) //se lee archivo monedas.csv y se llena arreglo
		{
			$csv[] = $result;
		}
		//echo '<pre>';
		//print_r($csv);
		echo '</pre>';
	}
	else die("<b>no hay directorio: ".$dir_path_files."</b>");
	fclose($info);
	
	//declaración de funcion
	function mostrarTexto($csv,$i) {
		echo "{$csv[2][0]}={$csv[$i+1][0]}<br>";  //imagen
		echo "{$csv[2][1]}={$csv[$i+1][1]}<br>";  //moneda
		echo "{$csv[2][2]}={$csv[$i+1][2]}<br>";  //Denominacion
		echo "{$csv[2][3]}={$csv[$i+1][3]}<br>";  //Peso gr
		echo "{$csv[2][4]}={$csv[$i+1][4]}<br>";  //Ley
		echo "{$csv[2][5]}={$csv[$i+1][5]}<br><br><br><br>";  //Precio de equilibrio MXN
	}
	
	//impresion de datos
	echo '<pre>';
	echo "<b>Valores de referencia: </b>";
	echo '</pre>';
	echo $csv[0][0]."= ".$csv[1][0];
	echo '</pre>';
	echo $csv[0][1]."= ".$csv[1][1];
	echo '</pre>';
	echo $csv[0][2]."= ".$csv[1][2];
	echo '</pre>';
	//visualizaciòn de informacion (imagenes, descripcion, nombre)
	if(is_dir($dir_path_img))
	{
		$files = scandir($dir_path_img);//escaneo de imagenes de la carpeta
		for($i=0;$i<count($files);$i++){
			if($files[$i]!='.'&&$files[$i]!='..')
			{
				echo "<img src='$dir_path_img$files[$i]' style='width:150px; height:150px;'><br>";
				//echo "$files[$i]<br>";
				mostrarTexto($csv,$i);
			}	
		}
	}
	else die("<b>no hay directorio: ".$dir_path_img."</b>");
 }
 else{
    header('location:index.php');
	exit();
}
ob_end_flush();
?>