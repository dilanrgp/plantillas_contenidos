<?php


	$template			= $_POST["TEMPLATE"];
	$template_number	= substr($template, -1);
	
	switch ( $template_number ) {
		case '1':
			$tipo 		= 'oferta';
			$has_bg_img	= false;
			$has_price	= true;
			$has_claim	= false;
			$bg_clases	= 'oferta';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '2':
			$tipo 		= 'oferta';
			$has_bg_img	= false;
			$has_price	= true;
			$has_claim	= true;
			$bg_clases	= 'oferta oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '3':
			$tipo 		= 'oferta';
			$has_bg_img	= true;
			$has_price	= true;
			$has_claim	= false;
			$bg_clases	= 'oferta oferta_con_bg';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			break;
		case '4':
			$tipo 		= 'oferta';
			$has_bg_img	= true;
			$has_price	= true;
			$has_claim	= true;
			$bg_clases	= 'oferta oferta_con_bg oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			//$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
		case '5':
			$tipo 		= 'evento';
			$has_bg_img	= true;
			$has_price	= false;
			$has_claim	= true;
			$bg_clases	= 'evento oferta_con_bg oferta_con_claim';
			$bg_color = 'bgwhite';
			$bgcontent = 'background-color: white';
			//$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
		case '6':
			$tipo 		= 'horarios';
			$has_bg_img	= false;
			$has_price	= false;
			$has_claim	= false;
			$bg_clases	= 'horarios';
			$bg_color = '';
			$bgcontent = 'background:linear-gradient(to right, #56D6BF, #49A9B6)';
			break;
	}	
	
///////////////////////
//  JCAM  
$idcontent         = 	$_POST["idcontent"];
$idcustomer = 61;  
$idcampaign   = $_POST["idcampaign"];

include("../accesomysql.php");

$directoriocliente = $directoriobase."/".$idcustomer."/";
$dirbase = "ladorianids.com";
$dirbase = "dev.ladorianids.com";
$dirbase = "idsv4.ladorianids.es";
$plantillascontenido = "/plantillascontenidov4/".$idcustomer."/";
//$dirbase = "idsv2.ladorian.es";

 
$conexionbd  = mysqli_connect($sql_host,$sql_login,$sql_pass,$sql_base) or die("Error en la conexión a la Base de Datos...:".mysqli_connect_error());
mysqli_select_db($conexionbd,$sql_base) OR  die ('Error en la selección de la Base de Datos...' . mysqli_error());


// Se mira qué TEMPLATE se ha elegido en la pantalla de elección de plantilla (porque se ha podido cambiar respecto al que hubiera)
$sql = 'SELECT idcontenttemplate AS wid from content_template where idcustomer = '. $idcustomer.
	   ' AND name = "'. $template  .'"';	   
$registro=mysqli_query($conexionbd,$sql) or die("Error en la query...:". $sql."  ".mysqli_error($conexionbd));	
$idcontenttemplate =0;
while ($datos=mysqli_fetch_array($registro))  
{
	$idcontenttemplate = $datos["wid"];
}

 
// Se incluye este codigo ya que cuando se elige una plantilla que no tiene estos campos de RRSS, falla	

	$data = array (
		//'img'		=> $_POST["IMG"],
		'title'		=> $_POST["TITLE"],
		'content'	=> $_POST["CONTENT"],
		'price'		=> $_POST["PRICE"],
		'price_cents'=> $_POST["PRICE-CENTS"],
		'unit' 			=> $_POST["UNIT"],
		'horario_title' => $_POST["HORARIO_TITLE"],
		'horario_1' => $_POST["HORARIO_1"],
		'horario_2' => $_POST["HORARIO_2"],
		'horario_3' => $_POST["HORARIO_3"],
		'horario_3' => $_POST["HORARIO_3"],
		'horario_4' => $_POST["HORARIO_4"],
		'horario_footer' => $_POST["HORARIO_FOOTER"],
		'discount'		=> $_POST["DISCOUNT"],
		'detail'		=> $_POST["DETAIL"],
		'oldprice'		=> $_POST["OLDPRICE"],
		'oldprice_cents'=> $_POST["OLDPRICE-CENTS"],
		'oldprice_unit' => $_POST["UNIT-OLDPRICE"],	
		'title_superlotes' => $_POST["TITLE-SUPERLOTES"],
		'title_superdescuento_uno' => $_POST["TITLE-SUPERDESCUENTO-UNO"],
		'title_superdescuento_dos'=> $_POST["TITLE-SUPERDESCUENTO-DOS"],		
	);

// Cuando alguno de los atributos sea una IMAGEN hay que ponerla como :   $_FILES["IMG"]["name"]
	
	$destination_path = getcwd().DIRECTORY_SEPARATOR;

	$imagenelegida="";
	$imagenleida="";

	$old_image="";
	
	
	$imagen="";

	if($_POST['imagenamostrar'] != ""){
		if($_POST['imagenamostrar'] == $_FILES['IMG']['name'] || $_FILES['IMG']['name'] == ""){
			$imagenleida =  $_POST['imagenamostrar'];
			$imagen = $imagenleida;
		}
		else
		{	//hay una foto y se puede reemplazar

			$old_image= $_POST['imagenamostrar'];
			$nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
			$target_path = $destination_path ."templates/".$nombre_image;
			move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
			$imagen = $directoriocliente.'templates/'.$nombre_image;	
		}		
	}
	else 
	{

		if($_FILES['IMG']['name']!=""){
			
			$nombre_image = time() . ".".pathinfo($_FILES['IMG']['name'], PATHINFO_EXTENSION);
			$target_path = $destination_path ."templates/".$nombre_image;
			move_uploaded_file($_FILES['IMG']['tmp_name'], $target_path);
			$imagen = $directoriocliente.'templates/'.$nombre_image;
		}
	}	


	$atributos[] = array(
						'img'		=> $imagen,
						'title'		=> $_POST["TITLE"],
						'content'	=> $_POST["CONTENT"],
						'price'		=> $_POST["PRICE"],
						'price_cents' => $_POST["PRICE-CENTS"],	
						'unit' 			=> $_POST["UNIT"],					
						'horario_title' => $_POST["HORARIO_TITLE"],
						'horario_1' => $_POST["HORARIO_1"],
						'horario_2' => $_POST["HORARIO_2"],
						'horario_3' => $_POST["HORARIO_3"],
						'horario_3' => $_POST["HORARIO_3"],
						'horario_4' => $_POST["HORARIO_4"],
						'horario_footer' => $_POST["HORARIO_FOOTER"],									
						'discount'		=> $_POST["DISCOUNT"],
						'detail'		=> $_POST["DETAIL"],
						'oldprice'		=> $_POST["OLDPRICE"],
						'oldprice_cents'=> $_POST["OLDPRICE-CENTS"],	
						'oldprice_unit' => $_POST["UNIT-OLDPRICE"],
						'title_superlotes' => $_POST["TITLE-SUPERLOTES"],
						'title_superdescuento_uno' => $_POST["TITLE-SUPERDESCUENTO-UNO"],
						'title_superdescuento_dos'=> $_POST["TITLE-SUPERDESCUENTO-DOS"],	
						 );							
						
	// Grabar en el campo "attributes" de content_template,	en formato JSON,, los valores de los campos variables
	$json_string = json_encode($atributos);
	// Se sustituye de momento la " por el caracter ^ ya que con la primera se corta la variable... En la grabacion se volvera a sustituir por la "
	$json_string = str_replace("\"","^",$json_string);
?>
<input type="hidden" name="atributos" id="atributos" value="<?php echo $json_string?>">
<input type="hidden" name="idcontenttemplate" id="idcontenttemplate" value="<?php echo $idcontenttemplate?>">
<input type="hidden" name="idcontent" id="idcontent" value="<?php echo $idcontent?>">
<input type="hidden" name="oldimage" id="oldimage" value="<?=$old_image?>">
<input type="hidden" name="destinationPath" id="destinationPath" value="<?=$destination_path?>">
<input type="hidden" name="idcampaign" id="idcampaign" value="<?=$idcampaign?>">
<!--- ENDJCAM -->


<!DOCTYPE html>
<html lang="es">
<head>
	
	<!--- 20122002  Miguel Palencia -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Plantillas TUSUPER</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<link rel="stylesheet" href="estilo.css?tmp=<?=time()?>">
	<link rel="stylesheet" href="css/style.css?tmp=<?=time()?>">
	<!-- -->
	
	<?php 

	if($has_bg_img){
		
		if(empty($imagen)){
			echo "<h1>Para continuar primero debes seleccionar una imagen</h1>";
			echo "<meta http-equiv=\"refresh\" content=\"3;url=". $_SERVER['HTTP_REFERER']."\"/>";
			die;
		}

		$tamanio = getImageSize($imagen);
		$ancho =$tamanio[0];
		$alto =$tamanio[1];

		if($ancho > $alto){
		?>
			<style>
				.oferta_con_bg #TEMPLATE_CONTENT {
					background-image: url('<?php echo $imagen; ?>')	!important;	
					background-repeat: no-repeat!important;
					background-size:cover!important;
					background-position:center center!important
				}
			</style>
		<?php
		}
		else{
		?>
		<style>
			.oferta_con_bg #TEMPLATE_CONTENT {
				background-image: url('<?php echo $imagen; ?>')	!important;	
				background-repeat: no-repeat!important;
				background-size:contain!important;
				background-position:center center!important
			}
		
		</style>
	<?php  }
	} 
	?>
	
<!---////////// JCAM -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script> 		

	<script language="JavaScript">
			function grabarplantilla()
			{
				$('#saveplantilla').addClass('disabled');
				//
				$('#saveplantilla').prop('onclick',null).off('click');

				var atributos = document.getElementById("atributos").value;
				var plantilla = document.getElementById("idcontenttemplate").value;
				var contenido = document.getElementById("idcontent").value;
				/* var idcampaign = document.getElementById("idcampaign").value;
				var oldimage = document.getElementById("oldimage").value;
				var destinationPath = document.getElementById("destinationPath").value; */
				var contenedor =
				
								 "<html lang='es'><head><meta http-equiv='Content-type' content='text/html; charset=utf-8'>"+								 
								 "<meta name='viewport' content='width=device-width, initial-scale=1'>"+								 
								 "<title>Plantillas TUSUPER</title>"+	
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"estilo.css'>"+								
								"<link rel='stylesheet' href='<?php echo $directoriocliente?>"+"css/style.css?v=01'>"+																							 

								"<?php if( $has_bg_img ) { 
									$tamanio = getImageSize($imagen);
									$ancho =$tamanio[0];
									$alto =$tamanio[1];
								if($ancho > $alto){	?>"+
								"	<style> "+
								"		.oferta_con_bg #TEMPLATE_CONTENT {" +
								"			background-image: url('<?php echo $imagen; ?>')	!important;	" +	
								"			background-repeat: no-repeat!important;" +	
								"			background-size:cover!important;" +	
								"			background-position:center center!important	" +	
								"		} "   +
								" 	.bgwhite{background-color:white;}"+
								"	</style> " + 
								"<?php } else { ?>"	+		
								"	<style> "+
								"		.oferta_con_bg #TEMPLATE_CONTENT {" +
								"			background-image: url('<?php echo $imagen; ?>')	!important;	" +		
								"			background-repeat: no-repeat!important;	" +	
								"			background-size:contain!important;	" +	
								"			background-position:center center!important	" +	
								"		} "   +
								" 	.bgwhite{background-color:white;}"+
								"	</style> " + 
								"<?php } }?>"	+						 							 
								 "</head><body>"+								 
								 document.getElementById("divcuerpoHTML").outerHTML+
								 "</body></html>";
	//			$('.loading').css('display','block');

	if (window.XMLHttpRequest)
				 {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
				 }
				 else
				 {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				 }

				 xmlhttp.onreadystatechange = function()
				 {
					 
						if (xmlhttp.responseText != 1)
						
						if (xmlhttp.readyState == 4 || xmlhttp.status == 200)  // http completado y ha sido ok
						{
							var response = xmlhttp.responseText; // 
							var result = JSON.parse(response);
							if(result.success) {
								parent.postMessage({domain:'ladorian.ids.template', 'key': 'template-url', 'value': result.data}, '*');
							}
						  
							//Se cierra la ventana y se vuelve al Formulario  
							window.close();

						}
				 };
				// Se pasa de esta forma ya que si se pasa por GET se pasan caracteres raros en el contenido
				params= "html="+contenedor+"&atributos="+atributos+"&plantilla="+plantilla+"&contenido="+contenido;				 
				xmlhttp.open("POST","<?php echo $directoriobase.'/grabaplantilla.php'?>",true);				
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send(params);
				
			}

	</script>	
<!---////////// ENDJCAM -->	
</head>

<body>

<div class="loading"></div>
<div  name = "divcuerpoHTML" id="divcuerpoHTML">
  
	<?php if($template_number == 1)    // TUSUPERPRECIO
	{
	?>
        <div class="plantilla1_container-up">
            <div class="plantilla1_up-left ">
                <div class="plantilla1_logo-container">
                    <div class="plantilla1_logo"></div>
                </div>
            </div>
        </div>
        <div class="plantilla1_container-mid">            
            <div class="plantilla1_left">
                <div class="plantilla1_left-image ">
                    <div class="plantilla1_image"	style="background-image: url(<?=$imagen;?>); 
													background-repeat:no-repeat; background-position:
													center center; background-size: contain;">
					</div>
					
                </div>             
            </div>
            <div class="plantilla1_right">
                <div class="plantilla1_name-product ">
                    <div class="plantilla1_name-container">
						<?php echo $data['title']; ?>
                    </div>
                     
                </div>
                 
                <div class="plantilla1_description-product ">
                    <div><?php echo $data['content']; ?></div>
                </div>
                <div class="plantilla1_up-tag ">
                    <div class="plantilla1_details plantilla1_background-yellow">
                        <div class="plantilla1_cents"><?php echo $data['price_cents']; ?><span style="font-weight: 400;">€</span></div>
                        <div class="plantilla1_units">/ <?php echo $data['unit']; ?></div>
                    </div>
                    <div class="plantilla1_price plantilla1_background-yellow"><?php echo $data['price']; ?></div>
                </div>
                
            </div>
        </div>
        <div class="plantilla1_container-bot">
            <div class="plantilla1_logo"></div>
        </div>
	<?php
	}
	?>	
	 
	<?php if($template_number == 2)     // TUSUPERDESCUENTO
	{
	?>
         <div class="container-general">

            <div class="plantilla2_yellow-background "></div>
            <div class="plantilla2_container-left">
    
                <div class="plantilla2_container-up ">
                    <div class="plantilla2_title">
                        <div class="plantilla2_title-img" >						
						</div>
                    </div>
                </div>

				
                <div class="plantilla2_container-mid">
    
                    <div class="plantilla2_product">
                        <div class="plantilla2_product-img "  
													style="background-image: url(<?=$imagen;?>); 
													background-repeat:no-repeat; background-position:
													center center; background-size: contain;"  >
						</div>
                    </div>
                    <div class="plantilla2_container-mid-left">
    
                        <div class="plantilla2_product-content ">
                            <div class="plantilla2_product-name">
                                <?php echo $data['title']; ?>
                            </div>
                            <div class="plantilla2_product-description">
								<?php echo $data['content']; ?>
                            </div>
                        </div>
                        <div class="plantilla2_container-bot">
                            <div class="plantilla2_logo"></div>
                        </div>
    
                    </div>
    
                </div>
                
            </div>
            <div class="plantilla2_container-right">
    
                <div class="plantilla2_discount-percent ">
                    <div class="plantilla2_title-percentage"><?php echo $data['title_superdescuento_uno']; ?></div>
                    <div class="plantilla2_number-percentage">-<?php echo $data['discount']; ?>%</div>
                </div>
    
                <div class="plantilla2_discount-price ">
                    <div class="plantilla2_title-price"><?php echo $data['title_superdescuento_dos']; ?></div>
                    <div class="plantilla2_number-price">
                        <div class="plantilla2_price"><?php echo $data['price']; ?></div>
                        <div class="plantilla2_cents"><?php echo $data['price_cents']; ?>€</div>
                    </div>
                </div>
    
                <div class="plantilla2_units ">
                    <?php echo $data['detail']; ?>
                </div>
            </div>
        </div>
	<?php
	}
	?>		
	
	
<?php if($template_number == 3)     // SUPERDESCUENTO 3X2
	{
	?>
        <div class=" container-general">

            <div class="plantilla3_yellow-background "></div>
            <div class="plantilla3_container-left">
    
                <div class="plantilla3_container-up ">
                    <div class="plantilla3_title">
                        <div class="plantilla3_title-img" >						
						</div>
                    </div>
                </div>
                <div class="plantilla3_container-down">
                    <div class="plantilla3_product-img "   style="background-image: url(<?=$imagen;?>); 
													background-repeat:no-repeat; background-position:
													center center; background-size: contain;"  >
					</div>
                </div>
            </div>
            <div class="plantilla3_container-right ">
                <div class="plantilla3_content-right">
                    <div class="plantilla3_title-offer">
                        <div><?php echo $data['title_superlotes']; ?></div>
                    </div>
    
                    <div class="plantilla3_product-content">
                        <div class="plantilla3_product-name">
                            <?php echo $data['title']; ?>
                        </div>
                        <div class="plantilla3_product-description">
                            <?php echo $data['content']; ?>
                        </div>
                    </div>
    
                    <div class="plantilla3_box-price">
                        <div class="plantilla3_backgroundcolor-price">
                            <div class="plantilla3_price"><?php echo $data['price']; ?></div>
                            <div class="plantilla3_unit-cent">
                                <div class="plantilla3_cents"><?php echo $data['price_cents']; ?>
											<span style="font-weight: normal;">€</span>
								</div>
                                <div class="plantilla3_unit-price">la unidad</div>
                            </div>
                        </div>
                    </div>
    
                    <div class="plantilla3_units">
                        <?php echo $data['detail']; ?> 
                    </div>
                </div>
            </div>
            
            <div class="plantilla3_container-bot">
                <div class="plantilla3_logo"></div>
            </div>
           
        </div>
         
	<?php
	}
	?>			

	
<?php if($template_number == 4) // SUPEROFERTA
	{
	?>
       <div class="plantilla4_container-up">
            <div class="plantilla4_up-left ">
                <div class="plantilla4_logo-container">
                    <div class="plantilla4_logo"></div>

                </div>
            </div>                      
        </div>

        
        <div class="plantilla4_container-mid">
            <div class="plantilla4_left">
                <div class="plantilla4_left-image " style="background-image: url(<?=$imagen;?>); 
													background-repeat:no-repeat; background-position:
													center center; background-size: contain;">    				    
				</div> 								
            </div>
		
			
            <div class="plantilla4_right">
				<div class="plantilla4_name-product ">
					<div>
						<?php echo $data['title'];?>
					</div>
				</div>  
                <div class="plantilla4_description-product ">
                    <div>
						<?php echo $data['content'];?>
                    </div>					

                </div>
                <div class="plantilla4_up-tag ">
                    <div class="plantilla4_details plantilla4_background-yellow">
                        <div class="plantilla4_cents"><?php echo $data['price_cents'];?><span style="font-weight: 400;">€</span></div>
                        <div class="plantilla4_units">/ kg</div>
                    </div>
                    <div class="plantilla4_price plantilla4_background-yellow"><?php echo $data['price'];?></div>
                </div>
                <div class="plantilla4_old-price ">
                    <div class="plantilla4_old-title">Precio anterior</div>
                    <div class="plantilla4_down-tag ">
                        <div class="plantilla4_details">
                            <div class="plantilla4_cents"><?php echo $data['oldprice_cents'];?><span style="font-weight: 400;">€</span></div>
                            <div class="plantilla4_units">/<?php echo $data['oldprice_unit'];?></div>
                        </div>
                        <div class="plantilla4_price "><?php echo $data['oldprice'];?></div>
                            <img class="plantilla4_img-line" src="<?php echo $directoriocliente?>media/Tachado.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="plantilla4_container-bot">
            <div class="plantilla4_logo"></div>
        </div> 
         
	<?php
	}
	?>			

	<?php if($template_number == 5)    // SUPERFOFERTAHOY
	{
	?>
       <div class="plantilla5_container-up ">
            <div class="plantilla5_logo-container"></div>
            <div class="plantilla5_title-up plantilla5_title-fade-in"><span class="plantilla5_tittle-efect">SOLO </span> HOY</div>
        </div>
        <div class="plantilla5_container-mid">
            <div class="plantilla5_up">
                <div class="plantilla5_name-product ">
                    <?php echo $data['title'];?>                   
                </div>
                <div class="plantilla5_description-product ">
					<?php echo $data['content'];?>                                   
                </div>
            </div>

            <div class="plantilla5_down">
                <div class="plantilla5_left " style="background-image: url(<?=$imagen;?>); 
													background-repeat:no-repeat; background-position:
													center center; background-size: contain;"></div>
                <div class="plantilla5_right ">
                    <div class="plantilla5_details">
                        <div class="plantilla5_cents"><?php echo $data['price_cents'];?><span style="font-weight: 400;">€</span></div>
                        <div class="plantilla5_units">/ <?php echo $data['unit'];?></div>
                    </div>
                    <div class="plantilla5_price"><?php echo $data['price'];?></div>
                </div>
            </div>
        </div>
        <div class="plantilla5_container-bot">
            <div class="plantilla5_logo"></div>
        </div>  

         
	<?php
	}
	?>				
	

	<?php if($template_number == 6)    // HORARIOS
	{
	?>
       <div class="plantilla6_container-up">
            <div class="plantilla6_up-left ">
                <div class="plantilla6_logo-container">
                    <div class="plantilla6_logo"></div>

                </div>
            </div>
            <div class="plantilla6_social-network-conatainer ">
                 <div class="plantilla6_social-network-logo" style="background-image: url('media/FB.png');"></div>
                 <div class="plantilla6_social-network-logo" style="background-image: url('media/IG.png');"></div>
                 <div class="plantilla6_social-network-logo" style="background-image: url('media/IN.png');"></div>
                 <div class="plantilla6_social-network-logo" style="background-image: url('media/WH.png');"></div>                 
            </div>            
        </div>

        
        <div class="plantilla6_container-mid">
            <div class="plantilla6_title "><?php echo $data['horario_title']; ?></div>
            <div class="plantilla6_item "><?php echo $data['horario_1']; ?></div>
            <div class="plantilla6_item "><?php echo $data['horario_2']; ?></div>
            <div class="plantilla6_item "><?php echo $data['horario_3']; ?></div>
			<div class="plantilla6_item "><?php echo $data['horario_4']; ?></div>

            <div class="plantilla6_button "><?php echo $data['horario_footer']; ?></div>
        </div>
        <div class="plantilla6_container-bot ">
            <div class="plantilla6_bot-background "></div>
            <div class="plantilla6_mail ">supermercadostusuper.com</div>
            <div class="plantilla6_number-container ">
                <div class="plantilla6_logo"></div>
                <div class="plantilla6_number-text">600.90.28.03</div>
            </div>
        </div>
         
	<?php
	}
	?>		
	
</div>	 
	 

<br><br><br><br>

<div class="wrapper" id="BUTTONS">
	<div class="btns">
		<?php $ira = "https://".$dirbase."/campaign/campaigns/campaigncontent/".$idcontent;?>
		<input type="button"  class="btn btn-success" id="saveplantilla" data-imagen="" data-imagen="" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();"> 
		<!---<input type="button" class="btn btn-success" name="guardar" value="Grabar Plantilla" onclick="grabarplantilla();window.close();	window.history.back();"> -->
		<input type="button" class="btn btn-primary" name="volver" value="Volver" onclick="window.close();	window.history.back();">			
	</div>
</div>

<script>
$(document).ready(function(){

	html2canvas($('#TEMPLATE_CONTENT'), {
	 onrendered: function (canvas) {
			var imgageData = canvas.toDataURL("image/png");
			var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
			$("#saveplantilla").data("imagen", newData);
			console.log(newData);
		}			
	 });			    
});
$(window).load(function() { 
	$(".loading").delay(5000).fadeOut("slow"); 
});				
</script>		


<style>
/* Absolute Center Spinner */
.loading {
position: fixed;
z-index: 999999;
height: 5em;
width: 5em;
overflow: show;
margin: auto;
top: 0;
left: 0;
bottom: 0;
right: 0;
}

/* Transparent Overlay */
.loading:before {
content: '';
display: block;
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
/* hide "loading..." text */
font: 0/0 a;
color: transparent;
text-shadow: none;
background-color: transparent;
border: 0;
}

.loading:not(:required):after {
content: '';
display: block;
font-size: 40px;
width: 1em;
height: 1em;
margin-top: -0.5em;
-webkit-animation: spinner 1500ms infinite linear;
-moz-animation: spinner 1500ms infinite linear;
-ms-animation: spinner 1500ms infinite linear;
-o-animation: spinner 1500ms infinite linear;
animation: spinner 1500ms infinite linear;
border-radius: 0.5em;
-webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@-moz-keyframes spinner {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@-o-keyframes spinner {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@keyframes spinner {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}

</style>

</body>
</html>