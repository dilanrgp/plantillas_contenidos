<?php
	/*
		Según el centro, hay que sacar uno de los valores siguientes:
		'vertical', 'horizontal', 'ambos'
	*/
    $orientation = 'ambos';
    if(isset($_GET['idsite']) && $_GET['idsite'] != 'undefined'){
        $site = $_GET['idsite'];
        $orientation = getOrientation($site);
    }

    function getOrientation($site){
        $orieantations = ['vertical', 'horizontal', 'ambos'];
        $apikey = 'ALRIDKJCS1SYADSKJDFS';
        $timestamp = time() * 1000;
        $string = $timestamp . $apikey;
        $keyhash = hash('sha256', $string);
        $host = $_SERVER['HTTP_HOST'];
        if(function_exists('curl_version')){
            $data = curl("https://$host/protected/site/$site/formats?timestamp=$timestamp&keyhash=$keyhash");
            $data = json_decode($data);
            $data = $data->data;
            $respOr = [];
            forEach($data as $format) {
                $respOr[] = strtolower($format->name);
            }
            $result = array_diff($orieantations,$respOr);
            if(count($result) == 1){
                return $result[2];
            }else{
                return $respOr[0];
            }
        }
    }
    function curl($url, $cookie = false, $post = false, $header = false, $follow_location = false, $referer=false,$proxy=false) {
        $ch = curl_init($url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_location);
        $response = curl_exec ($ch);
        curl_close($ch);
        return $response;
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Formulario de creación de contenidos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/form.css">
    </head>
<body>
<div class="container body <?php echo $orientation; ?>" role="main">
    <div class="row">
	    <form action="preview.php" method="POST" id="TEMPLATE_FORM" enctype="multipart/form-data">
            <fieldset class="col-md-12 form-group" id="TEMPLATE">
                <h3>Elije tu diseño</h3>
                <div class="row align-items-center">
                    <div class="form-check col">
                        <label for="TEMPLATE-1" class="template-selection">
                            <div class="cell">
                                <input type="radio" name="TEMPLATE" id="TEMPLATE-1" value="TEMPLATE-1">
                            </div>
                            <div class="cell">
                                <p>Oferta 1</p>
                                <img src="img/templates/template_1.jpg" class="temp-preview horizontal">
                                <img src="img/templates/template_1_V.jpg" class="temp-preview vertical">
                            </div>
                        </label>
                    </div>
                    <div class="form-check col">
                        <label for="TEMPLATE-2" class="template-selection">
                            <div class="cell">
                                <input type="radio" name="TEMPLATE" id="TEMPLATE-2" value="TEMPLATE-2">
                            </div>
                            <div class="cell">
                                <p>Oferta 2</p>
                                <img src="img/templates/template_2.jpg" class="temp-preview horizontal">
                                <img src="img/templates/template_2_V.jpg" class="temp-preview vertical">
                            </div>
                        </label>
                    </div>
                    <div class="form-check col">
                        <label for="TEMPLATE-3" class="template-selection">
                            <div class="cell">
                                <input type="radio" name="TEMPLATE" id="TEMPLATE-3" value="TEMPLATE-3">
                            </div>
                            <div class="cell">
                                <p>Oferta 3</p>
                                <img src="img/templates/template_3.jpg" class="temp-preview horizontal">
                                <img src="img/templates/template_3_V.jpg" class="temp-preview vertical">
                            </div>
                        </label>
                    </div>
                </div>
            </fieldset>
            <fieldset class="col-md-12 form-group" id="CONFIG">
                <h3>Configura tu plantilla</h3>
                <?php if($orientation == 'ambos') : ?>
                    <h4>Formato de pantalla</h4>
                    <div class="template-orientation table">
                        <span class="cell">Horizontal</span>
                        <div class="cell switch-container">
                            <label class="switch">
                                <input type="checkbox" id="ORIENTATION" name="ORIENTATION">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <span class="cell">Vertical</span>
                    </div>
                <?php endif; ?>
                <div class="config-container">
                    <div class="template-config">
                        <img src="img/logo.png" class="logo">
                        <div class="fields-ofertas">
                            <input type="text" name="TITLE" id="TITLE" placeholder="Aviso" />
                            <textarea name="DESCRIPCION" id="DESCRIPCION">2x1 en gafas de sol.</textarea>
                            <textarea name="SUBDESCRIPCION" id="SUBDESCRIPCION">Disfruta del verano con tus marcas favoritas.</textarea>
                            <textarea name="LEGAL" id="LEGAL">Oferta válida del 21/06/2022 al 31/08/2022 únicamente en este establecimiento. Oferta limitada a las 500 primeras personas. No se aplica a marcas. Consultar detalles dentro de la tienda.</textarea>
                        </div>
                        <div class="img-preview"></div>
                    </div>
                </div>
                <div class="fields-color">
                    <div class="row align-items-center">
                        <div class="form-check">
                            <label for="COLOR-1" class="color-selection">
                                <div class="cell">
                                    <input type="radio" name="COLOR" id="COLOR-1" value="#e1f4ff" checked>
                                </div>
                                <div class="cell">
                                    <div class="color-square" style="background-color: #e1f4ff"></div>
                                </div>
                            </label>
                        </div>
                        <div class="form-check">
                            <label for="COLOR-2" class="color-selection">
                                <div class="cell">
                                    <input type="radio" name="COLOR" id="COLOR-2" value="#e6ffb1">
                                </div>
                                <div class="cell">
                                    <div class="color-square" style="background-color: #e6ffb1"></div>
                                </div>
                            </label>
                        </div>
                        <div class="form-check">
                            <label for="COLOR-3" class="color-selection">
                                <div class="cell">
                                    <input type="radio" name="COLOR" id="COLOR-3" value="#deddfe">
                                </div>
                                <div class="cell">
                                    <div class="color-square" style="background-color: #deddfe"></div>
                                </div>
                            </label>
                        </div>
                        <div class="form-check">
                            <label for="COLOR-4" class="color-selection">
                                <div class="cell">
                                    <input type="radio" name="COLOR" id="COLOR-4" value="#fffbf6">
                                </div>
                                <div class="cell">
                                    <div class="color-square" style="background-color: #fffbf6"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="fields-img">
                    <h5>Imagen</h5>
                    <input type="file" name="IMG" id="IMG">
                </div>
                <div class="validation"></div>
                <div class="form-group text-center">
                    <input type="hidden" name="ORIENTATION_CENTRO" id="ORIENTATION_CENTRO" value="<?php echo $orientation; ?>">
                    <input type="submit" name="SUBMIT" id="SUBMIT" value="Previsualizar" class="btn btn-success">
                </div>
            </fieldset>
	    </form>
    </div>
</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/form.js?v=002"></script>
</body>
</html>
