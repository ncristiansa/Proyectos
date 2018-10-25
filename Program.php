<html>
  <head>
    <title></title>
    <script type="text/javascript" src="funciones.js"></script>
    <link href='estilos-quien-es-quien.css' type='text/css' rel='stylesheet' >
  </head>

  <body>
  <p id="p1prova" class="p1pro" ></p>
    <?php
    #Arrays que usaremos
    $arrayImg = array();
    $arrayGeneral = array();
    $arrayNombres = array();
    $Carac = array();
    //Nuevo!
    $arraycaract=file('config.txt');
    $caractconfig=array();
    $caractconfig2=array();
    $caractimatges=array();
    $caractimatges2=array();
    //Final Nuevo

    #Lectura de fichero.
    $Img = fopen("imatges.txt", "r") or die("Error al leer documento.");
    while(!feof($Img)){
      $linea=fgets($Img);
      $saltodelinea=nl2br($linea);
      array_push($arrayImg, $saltodelinea);
    }
    fclose($Img);

    # Añadimos el fichero en un array
    foreach ($arrayImg as $key => $i) {
      $names = explode(":",$i);
      array_push($arrayGeneral, $names);
    }

    # Creacion de array nombres
    $longGnl = count($arrayGeneral);
    for($i = 0; $i<$longGnl;$i++){
      array_push($arrayNombres, $arrayGeneral[$i][0]);
    }
    # Creacion de array caracteristicas
    for($i=0;$i<$longGnl;$i++){
      array_push($Carac, $arrayGeneral[$i][1]);
    }


    //Nuevo!
    $errorcaract=true;

    #Añadimos las caracteristicas del fichero config.txt a un array
    foreach ($arraycaract as $i ) {
      $names = explode(":",$i);
      array_push($caractconfig, $names);
    }

    #Añadimos las caracteristicas del fichero imatges.txt a un array

    foreach($arrayGeneral as $u) {
      array_push($caractimatges,$u[1] );

    }

    foreach ($caractimatges as $value) {
    	$names = explode(" ",$value);
    	array_push($caractimatges2,$names);
    }

    foreach ($caractconfig as $value) {
    	$names = explode(" ",$value);
    	array_push($caractconfig2,$names);
    }



    $longCaractimatges2=count($caractimatges2);

    for ($i=0; $i < $longCaractimatges2; $i++) {
    	if ($caractimatges2[$i][0]!=$caractconfig[0][0]){
    		$errorcaract=false;

    	}
    	elseif ($caractimatges2[$i][3]!=$caractconfig[1][0]) {
    		$errorcaract=false;
    	}
    	elseif ($caractimatges2[$i][6]!=$caractconfig[2][0]) {
    		$errorcaract=false;
    	}

    }
    //Final Nuevo!

    # 1. Una misma imagen (nombre de imagen) aparece dos veces en el archivo img.txt

    if(count($arrayNombres)>count(array_unique($arrayNombres))){
      $Logs = fopen("logs.txt", "w");
      fwrite($Logs, "¡Error! Hay un nombre repetido en el archivo imatges.txt.");
      fclose($Logs);
      echo"<h2>¡Error! Hay un nombre repetido en el archivo imatges.txt.</h2>";
    }elseif(count($Carac)>count(array_unique($Carac))){
      $Log = fopen("logs.txt", "w");
      fwrite($Log, "¡Error! Hay caracteristicas repetidas en el archivo imatges.txt.");
      fclose($Log);
      echo"<h2>¡Error! Hay caracteristicas repetidas en el archivo imatges.txt.</h2>";
    }elseif($errorcaract==false){
      $Log = fopen("logs.txt", "w");
      fwrite($Log, "¡Error! Hay caracteristicas que no estan en el archivo config.txt.");
      fclose($Log);
      echo"<h2>¡Error! Hay caracteristicas que no estan en el archivo config.txt.</h2>";

    }
    else{

    $arrayRandom=[];

    $numeros=range(0,11);
    shuffle($numeros);
    foreach ($numeros as $value) {
      array_push($arrayRandom,$value);
    }
    $arrayGeneral2=[];
    foreach ($numeros as $value) {
      array_push($arrayGeneral2, $arrayGeneral[$value][0]);
    }
    $cartaoculta = $arrayGeneral2[0];
    $img = $arrayGeneral2;

    $arrayDiv = [];
    $arrayId= [];
    $divs=range(1,12);
    shuffle($divs);
    foreach ($divs as $valor) {
      array_push($arrayDiv,"card".$valor);
      array_push($arrayId,"id".$valor);
    }
    $DatosPersonajes = array();
    $lgnl = count($arrayGeneral);
    for($e=0;$e<$lgnl;$e++){
      $prueba = explode(",", $arrayGeneral[$e][1]);
      array_push($DatosPersonajes, $prueba);
    }
    $AtributosCabello = array();
    $AtributosGafas = array();
    $AtributosSexo = array();
    $logitudp = count($DatosPersonajes);
    #Creando array AtributosCabello
    for($c=0;$c<$logitudp;$c++){
      $DatosC = explode(" ", $DatosPersonajes[$c][1]);
      array_push($AtributosCabello, $DatosC);
    }
    #Creando array AtributosGafas
    for($a=0;$a<$logitudp;$a++){
      $DatosG = explode(" ", $DatosPersonajes[$a][0]);
      array_push($AtributosGafas, $DatosG);
    }
    #Creando array AtributosSexo
    for($s=0;$s<$logitudp;$s++){
      $DatosS = explode(" ", $DatosPersonajes[$s][2]);
      array_push($AtributosSexo, $DatosS);
    }
    $y=2;
    $w=1;
    $i=0;
    foreach ($img as $fotos) {
      if( substr($fotos,-3)=="jpg" or substr($fotos,-3)=="png" or substr($fotos,-4)=="jpeg"){
        echo "<div id='$arrayId[$i]' onclick='girar(this.id)' class='$arrayDiv[$i]'>";
        echo "<div><img id='$fotos' onclick='nombreCartas(this.id)' src='imagenes/$fotos' width='100' height='100'></div>";
        echo "<div class='back'><img src='imagenes2/reversos.jpg' width='100' height='100'></div>";
        echo "</div>";
        $i=$i+1;
        if ($cartaoculta==$fotos) {
          echo "<div id='id13' class='divoculta'>";
          echo "<div><img src='imagenes2/reversos.jpg' width='120' height='120'></div>";
          for($o=0;$o<12;$o++){
            if($cartaoculta==$arrayNombres[$o]){
              $AtCabello = $AtributosCabello[$o][$y];
              $AtGafas = $AtributosGafas[$o][$w];
              $AtSexo = $AtributosSexo[$o][$y];
            }
          }

          echo"<div class='back'><img id='cartaOculta' src='imagenes/$fotos' width='150' height='150' cabello='$AtCabello' gafas='$AtGafas' sexo='$AtSexo'></div>";
          echo "</div>";

        }
    }
    }
      $namesC = array('rubio', 'moreno', 'castany');
        $namesG = array('si', 'no');
        $namesS = array('hombre', 'mujer');
        $longC = count($namesC);
        $longGS = count($namesG);

echo"<form method='post' name='formulario'>";
        echo"<div class='general'>";
          echo"<div class='caja1'>";
          echo"<p>¿Color de pelo?</p>";
            echo"<select name='OptCabello' id='OptCabello'>";
                echo"<option value='0'>--Selecciona--</option>";
              for($e=0;$e<$longC;$e++){
                echo"<option value='$namesC[$e]'>$namesC[$e]</option>";
              }
            echo"</select>";
          echo"</div>";
          echo"<div class='caja2'>";
          echo"<p>¿Tiene gafas?</p>";
            echo"<select name='OptGafas' id='OptGafas'>";
                echo"<option value='0'>--Selecciona--</option>";
              for($e=0;$e<$longGS;$e++){
                echo"<option value='$namesG[$e]'>$namesG[$e]</option>";
              }
            echo"</select>";
          echo"</div>";
          echo"<div class='caja3'>";
          echo"<p>¿Género?</p>";
              echo"<select name='OptSexo' id='OptSexo'>";
                  echo"<option value='0'>--Selecciona--</option>";
                for($i=0;$i<$longGS;$i++){
                  echo"<option value='$namesS[$i]'>$namesS[$i]</option>";
                }
              echo"</select>";
          echo"</div>";
          echo"<input type='button' name='pregunta' value='Haz la pregunta' onclick='validarPregunta()'>";
          echo"</form>";
          echo"<div class='mensajeCorrecto'>";
          echo"<p id='mensajeCorrecto'></p>";
          echo"</div>";
          echo"<div class='mensajeError'>";
          echo"<p id='mensajeError'></p>";
          echo"</div>";
        echo"</div>";

        echo"<input id='botoneasy' class='boton1' type='button' name='easy' value='MODO EASY'>";
    }
    ?>
    <script type="text/javascript">
      var CartaOculta='<?php echo $cartaoculta;?>'
      var arrayNombresCartas2=<?php echo json_encode($img);?>;
    </script>
  </body>
</html>
