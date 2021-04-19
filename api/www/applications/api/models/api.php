<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Api_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		$this->cityId = 1;
		$this->helpers();
		$this->options = null;
		$this->dataCity = null;
		$this->Area_Infraestructura = 0;
	}
	
	public function getDataCity($cityId = false) {
		if($cityId == false) $cityId = $this->cityId;
		
		$query	 = "SELECT * from dataset";
		$query  .= " where id_city=".$cityId;
		$data	 = $this->Db->query($query);
		
		if(!$data and !is_array($data)) return false;
		
		return $data[0];
	}
	
	public function getResults($options) {
		$this->options = $options;
		$this->dataCity = $this->getDataCity();
		
		if($this->options["infraestructura"] == "CC") {
			$data["calculadora"] = $this->getCC();
		} elseif($this->options["infraestructura"] == "CCE") {
			$data["calculadora"] = $this->getCCE();
		} elseif($this->options["infraestructura"] == "BB") {
			$data["calculadora"] = $this->getBB();
		} elseif($this->options["infraestructura"] == "CICA") {	
			$data["calculadora"] = $this->getCICA();
		} else {
			return null;
		}
		
		$data["csv_file"] = $this->getCSV($data["calculadora"]);
		$data["egresos"]["estatales"] = $this->getEgresos();
		$data["egresos"]["municipales"] = $this->getEgresos("municipales");
		$data["ingresos"]["estatales"] = $this->getIngresos();
		$data["ingresos"]["municipales"] = $this->getIngresos("municipales");
		$data["ingresos"]["porcentajes"] = $this->getIngresosPorcentajes();
		$data["ingresos"]["porcentajes1000"] = $this->getIngresosPorcentajes("1000");
		$data["egresos"]["porcentajes"] = $this->getEgresosPorcentajes();
		$data["egresos"]["porcentajes1000"] = $this->getEgresosPorcentajes("1000");
		
		$data["options"] = $this->options;
		return $data;
	}
	
	public function getCSV($data) {
		$csv = "Numero,Concepto,Cantidad,Precio unitario,Importe" . "\n";
		
		foreach($data as $key => $value) {
			if(is_int($key)) {
				$csv .= $key . "," . $value["concepto"] . "," . $value["cantidad"] . "," . $value["precio_unitario"] . "," . $value["importe"] . "\n"; 
			} elseif($key!="gran_total" and $key!="subtotal_acumulado" and $key!="proyecto_ejecutivo" and $key!="costo_supervision" and $key!="impuesto_al_millar" and $key!="iva" and $key!="total") {
				$concept = "";
				
				if($key == "subtotal_preliminares") {
					$concept = "Preliminares";
				} elseif($key == "subtotal_banquetas_guarniciones") {
					$concept = "Banquetas y Guarniciones";
				} elseif($key == "subtotal_pavimentos") {
					$concept = "Pavimentos";
				} elseif($key == "subtotal_alcantarillado") {
					$concept = "Alcantarillado";
				} elseif($key == "subtotal_senalizacion_obra") {
					$concept = "Senalizacion de Obra";
				} elseif($key == "subtotal_senalizacion_horizontal") {
					$concept = "Senalizacion Horizontal";
				} elseif($key == "subtotal_senalizacion_vertical") {
					$concept = "Senalizacion Vertical";
				} elseif($key == "subtotal_dispositivos_transito") {
					$concept = "Dispositivos de Control de Transito";
				} elseif($key == "subtotal_mobiliario") {
					$concept = "Mobiliario";
				} elseif($key == "subtotal_biciestacionamientos") {
					$concept = "Biciestacionamientos";
				}
				
				$csv .= "NA," . $concept . "," . $value . ",NA,NA" . "\n";
			}
		}
		
		$csv .= "NA,Subtotal acumulado," . $data["subtotal_acumulado"] . ",NA,NA" . "\n";
		$csv .= "NA,IVA," . $data["iva"] . ",NA,NA" . "\n";
		$csv .= "NA,Total," . $data["total"] . ",NA,NA" . "\n";
		$csv .= "NA,Proyecto Ejecutivo 5%," . $data["proyecto_ejecutivo"] . ",NA,NA" . "\n";
		$csv .= "NA,Supervision de Obra 2%," . $data["costo_supervision"] . ",NA,NA" . "\n";
		$csv .= "NA,Impuesto de cinco al millar 0.5%," . $data["impuesto_al_millar"] . ",NA,NA" . "\n";
		$csv .= "NA,Gran total," . $data["gran_total"] . ",NA,NA" . "\n";
		
		$csv = trim($csv, "\n");

		$date =new DateTime();
		$timestamp = $date->getTimestamp();
		$filename = $_SERVER['DOCUMENT_ROOT'] . "/assets/files/calculadora-".$timestamp.".csv";
		$fp = fopen($filename, "wb");
		fwrite($fp, $csv);
		fclose($fp);
		
		return "http://ceci.itdp.mx/assets/files/calculadora-".$timestamp.".csv";
	}
	
	//{"estado":6,"municipio":2,"infraestructura":"CC","A":1,"B":20,"C":1,"D":3,"E":4,"F":8,"G":8,"H":0,"I":0,"J":2,"K":15,"L":"SI","M":"SI","N":"SI"}
	/*Ciclovia por elemento de confinamiento*/
	public function getCC() {
		$data = null;
		
		$data[1]["concepto"] = '"Trazo y nivelacion de plazas, andadores y parques, con equipo de topografia primeros 10000 m2."';
		$data[1]["precio_unitario"] = 2.24;
		$data[1]["cantidad"] = 1000*$this->options["A"]*$this->options["B"];
		
		$data[2]["concepto"] = '"Estas son las columnas que se publican para el usuario"';
		$data[2]["precio_unitario"] = 336.65;
		$data[2]["cantidad"] = (1.3*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[3]["concepto"] = '"Demolicion por medios manuales de pavimento de concreto asfaltico sin afectar base, para trabajos de bacheo, medido en banco."';
		$data[3]["precio_unitario"] = 328.24;
		$data[3]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[4]["concepto"] = '"Carga, acarreo en carretilla y descarga a primera estacion de 20 m, de material producto de demolicion, medido en banco."';
		$data[4]["precio_unitario"] = 63.12;
		$data[4]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);

		$data[5]["concepto"] = '"Acarreo en carretilla de material, producto de demolicion, a estaciones subsecuentes de 20 m."';
		$data[5]["precio_unitario"] = 22.31;
		$data[5]["cantidad"] = 2*$data[4]["cantidad"];
		
		$data[6]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga, de material de demolicion de concreto hidraulico, volumen medido colocado."';
		$data[6]["precio_unitario"] = 107.01;
		$data[6]["cantidad"] = (1.3*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[7]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto, kilomeros subsecuentes, zona urbana."';
		$data[7]["precio_unitario"] = 10.16;
		$data[7]["cantidad"] = 20*$data[6]["cantidad"];
		
		$data[8]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga de material de demolicion de carpeta asfaltica, volumen medido colocado."';
		$data[8]["precio_unitario"] = 99.93;
		$data[8]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[9]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto asfaltico, kilometros subsecuentes, zona urbana."';
		$data[9]["precio_unitario"] = 9.15;
		$data[9]["cantidad"] = 20*$data[8]["cantidad"];
		
		$data[10]["concepto"] = '"Desmantelamiento de poste de esquina de 60 mm de diametro en cerca de 2.00 m de altura, incluye: capucha, accesorios y demolicion de cimentacion."';
		$data[10]["precio_unitario"] = 53.3;
		$data[10]["cantidad"] = $this->options["E"]*$this->options["A"];
		
		$data[11]["concepto"] = '"Preparacion, conformacion y compactacion de subrasante para banquetas, en forma manual, incluye incorporacion de agua."';
		$data[11]["precio_unitario"] = 12.49;
		$data[11]["cantidad"] = 72.5*$this->options["G"];
		
		$data[12]["concepto"] = '"Suministro y colocacion de tepetate de 10 cm de espesor compactado al 85% proctor, para desplante de banqueta, incluye incorporacion de agua."';
		$data[12]["precio_unitario"] = 30.75;
		$data[12]["cantidad"] = (1000*$this->options["H"]*$this->options["I"]);
		
		$data[13]["concepto"] = '"Banqueta de 10 cm de espesor de concreto hidraulico resistencia normal f c= 150 kg/cm2,colados en cuadros de 0.80 x 1.60 m, alternados , acabado color negro y blanco deslavado conacabado, incluye: cimbrado, descimbrado, lavado, materiales y mano de obra"';
		$data[13]["precio_unitario"] = 396.27;
		$data[13]["cantidad"] = $data[11]["cantidad"]+$data[12]["cantidad"];
		
		$data[14]["concepto"] = '"Acabado con volteador en las aristas de banquetas, en tramos alternados."';
		$data[14]["precio_unitario"] = 11.97;
		$data[14]["cantidad"] = (92.4*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[15]["concepto"] = '"Acabado con volteador en las aristas y separacion de placas de banqueta, en tramos alternados."';
		$data[15]["precio_unitario"] = 11.97;
		$data[15]["cantidad"] = ((1000*$this->options["H"])/3)*$this->options["I"];
		
		$data[16]["concepto"] = '"Guarnicion de concreto hidraulico resistencia normal f c= 200 kg/cm2, seccion trapezoidal de 15 x 20 x 35 cm"';
		$data[16]["precio_unitario"] = 176.78;
		$data[16]["cantidad"] = (48.16*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[17]["concepto"] = '"Barrido de base previo al riego de impregnacion"';
		$data[17]["precio_unitario"] = 1.71;
		$data[17]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[18]["concepto"] = '"Corte con sierra en pavimento de concreto asfaltico, con profundidad de 2.5 cm a 5.00 cm"';
		$data[18]["precio_unitario"] = 8.42;
		$data[18]["cantidad"] = ((0.20*$data[17]["cantidad"])/12.5)*15;
		
		$data[19]["concepto"] = '"Bacheo de 7.5 cm de espesor con concreto asfaltico compactado al 90% de su densidad teorica maxima, con riego de liga e impregnacion, incluye: los materiales, la mano de obra, preparacion de la superficie, la herramienta y el equipo necesarios para la correcta ejecucion delos trabajos"';
		$data[19]["precio_unitario"] = 286.259999705783;
		$data[19]["cantidad"] = (1000*($this->options["A"]*$this->options["B"]))*0.2;
		
		$data[20]["concepto"] = '"Acarreo en camion, de concreto asfaltico templado para bacheo (maximo 20 m3), kilometros subsecuentes."';
		$data[20]["precio_unitario"] = 16.3000019614381;
		$data[20]["cantidad"] = (((0.2*$data[17]["cantidad"])/12.5)*(0.9375))*20;
		
		$data[21]["concepto"] = '"Riego de sello a base de Slurry Seal, abase de emulsion asfaltica ecr-mod con aditivos quimicos compatible con agua y agregado arena fina tipo I, como acabado final en ciclovia, incluye: materiales, manodeobray equipoy herramientamenor"';
		$data[21]["precio_unitario"] = 55.23;
		$data[21]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[22]["concepto"] = '"Renivelacion de brocales de concreto."';
		$data[22]["precio_unitario"] = 374.84;
		$data[22]["cantidad"] = $this->options["A"]*15;
		
		$data[23]["concepto"] = '"Renivelacion de tapa de registro de 1.00 x 0.65 m, incluye: concreto f c = 150 kg/cm2, agregado maximo de 20 mm."';
		$data[23]["precio_unitario"] = 524.6;
		$data[23]["cantidad"] = $this->options["A"]*20;
		
		$data[24]["concepto"] = '"Renivelacion de coladera de banqueta con brocales de concreto o fierro fundido, incluye: muro de tabique recocido, aplanado con mortero cemento arena 1:3."';
		$data[24]["precio_unitario"] = 313.08;
		$data[24]["cantidad"] = $this->options["A"]*4;
		
		$data[25]["concepto"] = '"Renivelacion de coladera de piso de una rejilla, incluye: muro de tabique recocido y aplanado con mortero cemento-arena 1:3."';
		$data[25]["precio_unitario"] = 269.82;
		$data[25]["cantidad"] = $this->options["A"]*5;
		
		$data[26]["concepto"] = '"Suministro  e  instalacion  de  registro  de  polietileno  de  alta  resistencia,  para  pluvial"';
		$data[26]["precio_unitario"] = 1988.66;
		$data[26]["cantidad"] = $this->options["A"]*1;
		
		$data[27]["concepto"] = '"Suministro y colocacion de marco y rejilla de polietileno alta resistencia boca de tormenta de 66 x 55 cm."';
		$data[27]["precio_unitario"] = 3693.42;
		$data[27]["cantidad"] = $this->options["A"]*2;
		
		$data[28]["concepto"] = '"Suministro e instalacion de marco con tapa de polietileno alta resistencia de 5x 50, para caja de valvula."';
		$data[28]["precio_unitario"] = 2027.44;
		$data[28]["cantidad"] = $this->options["A"]*3;
		
		$data[29]["concepto"] = '"Suministro y colocacion de brocal y tapa de polietileno alta resistencia, para pozo de visita."';
		$data[29]["precio_unitario"] = 2805.9;
		$data[29]["cantidad"] = $this->options["A"]*3;
		
		$data[30]["concepto"] = '"Tubo de PVC tipo sanitario union cementar, extremos lisos de 200 mm de diametro."';
		$data[30]["precio_unitario"] = 215.82;
		$data[30]["cantidad"] = $this->options["A"]*15;
		
		$data[31]["concepto"] = '"Dispositivo DPP-1 Barrera Plastica Vehicular de proteccion vial fabricada en polietileno de media densidad color: naranja, medidas: l: 156 cm, a: 59.5 cm, h: 85 cm, capacidad de llenado: 72 cm3, parausar vacia, con arena a una tercera parte de su capacidad."';
		$data[31]["precio_unitario"] = 3232.01;
		$data[31]["cantidad"] = $this->options["A"]*50;
		
		$data[32]["concepto"] = '"Trafisit, fabricado en polietileno medidas: diametro de base: 50 cm, diametro superior: 43 cm, altura: 107 cm, con 2 cintas reflejantes grado ingenieria sin base"';
		$data[32]["precio_unitario"] = 718.62;
		$data[32]["cantidad"] = $this->options["A"]*50;
		
		$data[33]["concepto"] = '"Pintado de raya de cruce de peatones 40 cm de ancho con pintura coldplastic color blanco con reflejante (microesferas)."';
		$data[33]["precio_unitario"] = 80;
		$data[33]["cantidad"] = (7+$this->options["B"])*12;
		
		$data[34]["concepto"] = '"Pintado de raya de alto con pintura coldplastic color blanco en superficies de rodamiento para definir el alto de los vehiculos en los cruces, de 60 cm de ancho."';
		$data[34]["precio_unitario"] = 120;
		$data[34]["cantidad"] = (7+$this->options["B"])*$this->options["F"]*2;
		
		$data[35]["concepto"] = '"Pintado de pictograma area de espera ciclista y motociclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de espera en alto de vialidades, de dimensiones de 3.20 m de altura por 1.80 m de ancho."';
		$data[35]["precio_unitario"] = 2*384.25;
		$data[35]["cantidad"] = 2*$this->options["F"];
		
		$data[36]["concepto"] = '"Pintado de raya sencilla para delimitar arroyo vial con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho"';
		$data[36]["precio_unitario"] = 20;
		$data[36]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[37]["concepto"] = '"Pintado de raya discontinua para delimitar carriles de circulacion con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho por 2.5 metros de largo"';
		$data[37]["precio_unitario"] = 20;
		$data[37]["cantidad"] = ($this->options["D"]-1)*(300*$this->options["A"])+(30*$this->options["F"]);
		
		$data[38]["concepto"] = '"Pintado de pictograma carril exclusivo bicicleta, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de uso exclusivo para bicicletas, de dimensiones de 6.10 m de altura por 1.50 m de ancho."';
		$data[38]["precio_unitario"] = 1968.93;
		$data[38]["cantidad"] = 2*$this->options["F"];
		
		$data[39]["concepto"] = '"Pintado de flecha de sentido (frente y vuelta a la derecha/izquierda) con pintura coldplastic color  blanco y reflejante (microesferas), en superficies de rodamiento para indicar direccion en vialidades con velocidades de 30 km/hora o menores, de dimensiones de flecha de 5.00 m de longitud, 2.70 m de ancho y 0.40 m de base."';
		$data[39]["precio_unitario"] = 430;
		$data[39]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[40]["concepto"] = '"Pintado de pictograma y raya para parada de transporte publico, con pintura pintura colsplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area deparada de transporte publico, (BUS) de dimensiones de 1.60 m de altura por 1.88 m de ancho. y franjas de 10 cmanchopor 20 mts delong. franjade 60 cmpor 3.20 long."';
		$data[40]["precio_unitario"] = 1377.52;
		$data[40]["cantidad"] = $this->options["F"]/3;
		
		$data[41]["concepto"] = '"Pintado de raya doble de 10 cm cada una con pintura coldplastic color blanco y reflejante (microesferas),  en superficies de rodamiento,  para indicar  elemento de confinamiento."';
		$data[41]["precio_unitario"] = 60;
		$data[41]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[42]["concepto"] = '"Pintado de pictograma de control de velocidad, con pintura coldplastic color blanco  y  reflejante (microesferas) en superficies  de rodamiento para  vialidades  con velocidades menores a 100 km/hora, de dimensiones de 4.00 m de altura por 2.00 m de ancho."';
		$data[42]["precio_unitario"] = 700;
		$data[42]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[43]["concepto"] = '"Pintado de raya para cruces ciclistas, con pintura coldplastic color verde y reflejante (microesferas) en superficies de rodamiento para definir el ancho de carril exclusivo ciclista encruces, de 40 cm de ancho."';
		$data[43]["precio_unitario"] = 256.63;
		$data[43]["cantidad"] = 100*$this->options["F"];
		
		$data[44]["concepto"] = '"Pintado de pictograma cruce ciclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el cruce de ciclistas en vialidades, de dimensiones de 2.10 m de altura por 1.18 m de ancho."';
		$data[44]["precio_unitario"] = 322.68;
		$data[44]["cantidad"] = $this->options["F"];
		
		$data[45]["concepto"] = '"Pintado en guarnicion de concreto, con pintura esmalte 100 biosensecolor amarilla y reflejante (microesferas) para indicar el area de espera en alto de vialidades de 15 cm de corona y de 0 a 30 cmde altura."';
		$data[45]["precio_unitario"] = 47.55;
		$data[45]["cantidad"] = 60*$this->options["F"];
		
		$data[46]["concepto"] = '"Senal informativa de servicios via ciclista 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[46]["precio_unitario"] = 1797.23;
		$data[46]["cantidad"] = $this->options["F"];
		
		$data[47]["concepto"] = '"Senal informativa de servicios parada de transporte publico 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[47]["precio_unitario"] = 1797.23;
		$data[47]["cantidad"] = $this->options["F"]/3;
		
		$data[48]["concepto"] = '"Senal  restrictiva de prohibido estacionarse 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor."';
		$data[48]["precio_unitario"] = 1834.81;
		$data[48]["cantidad"] = 2*$this->options["F"];
		
		$data[49]["concepto"] = '"Senal  restrictiva de velocidad 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor."';
		$data[49]["precio_unitario"] = 1834.81;
		$data[49]["cantidad"] = $this->options["F"];
		
		$data[50]["concepto"] = '"Senal preventiva de cruce ciclista 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[50]["precio_unitario"] = 1696.17;
		$data[50]["cantidad"] = $this->options["F"];
		
		$data[51]["concepto"] = '"Senal preventiva de motocicletas 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[51]["precio_unitario"] = 1834.81;
		$data[51]["cantidad"] = $this->options["F"];
		
		$data[52]["concepto"] = '"Dispositivo diverso indicador de obstaculo caramelo (DD-5c) de 60 cm x 30 cm  fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor, sin poste."';
		$data[52]["precio_unitario"] = 739.63;
		$data[52]["cantidad"] = $this->options["A"]/3;
		
		$data[53]["concepto"] = '"Suministro y colocacion de elemento confinador de carril confibici, fabricado en polietileno de media densidad, moldeado por proceso de inyeccion a baja presion, color amarillo, medidas: largo 180 cm., ancho 40 cm., altura 13 cm., reflejante tipo microesferaen ambos extremos y 2 Franjas laterales (color amarillo), con nervaduras (superficie antiderrapante) del lado de la rampa para las bicicletas, con logotipo en bajo relieve bicicleta, fijacion con 6 tornillos 1/2 x 12 y resinaepoxica."';
		$data[53]["precio_unitario"] = 4583.01;
		$data[53]["cantidad"] = 215*$this->options["A"];
		
		$data[54]["concepto"] = '"Hito abatible de polietileno de alta densidad de 0.82 m de alto, diametro de 10.7 m Y 19.5 en la base, temperatura de deflexion por calor a 80°  los trabajos incluyen: la fabricacion en planta, la carga, acarreo al sitio de la obra, trazo y nivelacion, perforacion es para fijacion, colocacion de piezas de concreto y pernos con resina, los materiales, mano de obra, herramienta y equipo necesario para su correcta ejecucion."';
		$data[54]["precio_unitario"] = 417*1.25;
		$data[54]["cantidad"] = 12*$this->options["F"];
		
		$data[55]["concepto"] = '"Suministro y colocacion de botones blancos, con dos reflejantes, asentado con pegamento epoxico"';
		$data[55]["precio_unitario"] = 62.41;
		$data[55]["cantidad"] = ((133*$this->options["A"])*($this->options["D"]-1))+(20*$this->options["F"]);
		
		$data[56]["concepto"] = '"Suministro y colocacion de bolardo fabricado en polietileno de una sola pieza con tubo de acero interno, accesorio para delimitar zonas peatonales banquetas, camellones, diseno modernoy anguardistadealtaresistencia, medidas diametro 15 cm., altura 130 cm."';
		$data[56]["precio_unitario"] = 1296.73;
		$data[56]["cantidad"] = 8*$this->options["F"];
		
		$data[57]["concepto"] = '"Semaforo ciclista con carcasa fabricada en policarbonato de alto impacto 2 secciones (R,V) simulan la forma de una bicicleta pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[57]["precio_unitario"] = 4800+52600;
		$data[57]["cantidad"] = $this->options["J"];
		
		$data[58]["concepto"] = '"Semaforo peatonal incandescente de 20 cms, Fabricados en policarbonato, fundidos a presion segun la especificacion de aleacion SC-848 (n.380), Cuerpo fundido en una sola pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[58]["precio_unitario"] = 9600+52600;
		$data[58]["cantidad"] = 4*$this->options["J"];

		$data[59]["concepto"] = '"Estacionamiento para bicicleta tipo U invertida a base de tubo redondo de acero galvanizado con diametro de 2, cedula 30 sin costura, con senalamiento de placa de acero de 15 X 20 cm X 1/8 de espesor con senal informativa de doble vista hecha en material reflejante grado ingenieria. Incluye dos anclas de barra de acero pulido tipo cold-roll de 20 cm de largo y 1/2 de diametro. El precio Incluye el equipo y la herramienta necesarios para la correcta ejecucion de los trabajos."';
		$data[59]["precio_unitario"] = 3000;
		$data[59]["cantidad"] = $this->options["K"];
		
		$result = $this->getImporte($data);
		
		$subtotal = 0;
		for($i = 1; $i <= 10; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_preliminares"] = $subtotal;
		
		$subtotal = 0;
		for($i = 11; $i <= 16; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_banquetas_guarniciones"] = $subtotal;
		
		$subtotal = 0;
		for($i = 17; $i <= 21; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_pavimentos"] = $subtotal;
		
		$subtotal = 0;
		for($i = 22; $i <= 30; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_alcantarillado"] = $subtotal;
		
		$subtotal = 0;
		for($i = 31; $i <= 32; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_obra"] = $subtotal;
		
		$subtotal = 0;
		for($i = 33; $i <= 45; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_horizontal"] = $subtotal;
		
		$subtotal = 0;
		for($i = 46; $i <= 52; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_vertical"] = $subtotal;
		
		$subtotal = 0;
		for($i = 53; $i <= 58; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_dispositivos_transito"] = $subtotal;
		
		$result["subtotal_mobiliario"] = $result[59]["importe"];
		
		return $result;
	}
	
	//{"estado":6,"municipio":2,"infraestructura":"CCE","A":1,"B":15,"C":1,"D":3,"E":4,"F":8,"G":8,"H":0,"I":0,"J":2,"K":15,"L":"SI","M":"SI","N":"SI"}
	/*Ciclovia por cordon de estacionamiento*/
	public function getCCE() {
		$data = null;
		
		$data[1]["concepto"] = '"Trazo y nivelacion de plazas, andadores y parques, con equipo de topografia primeros 10000 m2."';
		$data[1]["precio_unitario"] = 2.24;
		$data[1]["cantidad"] = 1000*$this->options["A"]*$this->options["B"];
		
		$data[2]["concepto"] = '"Estas son las columnas que se publican para el usuario"';
		$data[2]["precio_unitario"] = 336.65;
		$data[2]["cantidad"] = (2.6*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[3]["concepto"] = '"Demolicion por medios manuales de pavimento de concreto asfaltico sin afectar base, para trabajos de bacheo, medido en banco. "';
		$data[3]["precio_unitario"] = 328.24;
		$data[3]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[4]["concepto"] = '"Carga, acarreo en carretilla y descarga a primera estacion de 20 m, de material producto de demolicion, medido en banco."';
		$data[4]["precio_unitario"] = 63.12;
		$data[4]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);

		$data[5]["concepto"] = '"Acarreo en carretilla de material, producto de demolicion, a estaciones subsecuentes de 20 m."';
		$data[5]["precio_unitario"] = 22.31;
		$data[5]["cantidad"] = 2*$data[4]["cantidad"];
		
		$data[6]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga, de material de demolicion de concreto hidraulico, volumen medido colocado."';
		$data[6]["precio_unitario"] = 107.01;
		$data[6]["cantidad"] = (2.6*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[7]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto, kilomeros subsecuentes, zona urbana. "';
		$data[7]["precio_unitario"] = 10.16;
		$data[7]["cantidad"] = 20*$data[6]["cantidad"];
		
		$data[8]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga de material de demolicion de carpeta asfaltica, volumen medido colocado."';
		$data[8]["precio_unitario"] = 99.93;
		$data[8]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		

		$data[9]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto asfaltico, kilometros subsecuentes, zona urbana."';		
		$data[9]["precio_unitario"] = 9.15;
		$data[9]["cantidad"] = 20*$data[8]["cantidad"];
		
		$data[10]["concepto"] = '"Desmantelamiento de poste de esquina de 60 mm de diametro en cerca de 2.00 m de altura, incluye: capucha, accesorios y demolicion de cimentacion."';
		$data[10]["precio_unitario"] = 53.3;
		$data[10]["cantidad"] = $this->options["E"]*$this->options["A"];
		
		$data[11]["concepto"] = '"Preparacion, conformacion y compactacion de subrasante para banquetas, en forma manual, incluye incorporacion de agua."';
		$data[11]["precio_unitario"] = 12.49;
		$data[11]["cantidad"] = 145*$this->options["G"];
		
		$data[12]["concepto"] = '"Suministro y colocacion de tepetate de 10 cm de espesor compactado al 85% proctor, para desplante de banqueta, incluye incorporacion de agua."';
		$data[12]["precio_unitario"] = 30.75;
		$data[12]["cantidad"] = (1000*$this->options["H"]*$this->options["I"]);
		
		$data[13]["concepto"] = '"Banqueta de 10 cm de espesor de concreto hidraulico resistencia normal f.c= 150 kg/cm2,colados en cuadros de 0.80 x 1.60 m, alternados , acabado color negro y blanco deslavado conacabado, incluye: cimbrado, descimbrado, lavado, materiales y mano de obra"';
		$data[13]["precio_unitario"] = 396.27;
		$data[13]["cantidad"] = $data[11]["cantidad"]+$data[12]["cantidad"];
		
		$data[14]["concepto"] = '"Acabado con volteador en las aristas de banquetas, en tramos alternados."';
		$data[14]["precio_unitario"] = 11.97;
		$data[14]["cantidad"] = (184.8*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[15]["concepto"] = '"Acabado con volteador en las aristas y separacion de placas de banqueta, en tramos alternados."';
		$data[15]["precio_unitario"] = 11.97;
		$data[15]["cantidad"] = ((1000*$this->options["H"])/3)*$this->options["I"];
		
		$data[16]["concepto"] = '"Guarnicion de concreto hidraulico resistencia normal f c= 200 kg/cm2, seccion trapezoidal de 15 x 20 x 35 cm"';
		$data[16]["precio_unitario"] = 176.78;
		$data[16]["cantidad"] = (96.32*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[17]["concepto"] = '"Barrido de base previo al riego de impregnacion"';
		$data[17]["precio_unitario"] = 1.71;
		$data[17]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[18]["concepto"] = '"Corte con sierra en pavimento de concreto asfaltico, con profundidad de 2.5 cm a 5.00 cm"';
		$data[18]["precio_unitario"] = 8.42;
		$data[18]["cantidad"] = ((0.20*$data[17]["cantidad"])/12.5)*15;
		
		$data[19]["concepto"] = '"Bacheo de 7.5 cm de espesor con concreto asfaltico compactado al 90% de su densidad teorica maxima, con riego de liga e impregnacion, incluye: los materiales, la mano de obra, preparacion de la superficie, la herramienta y el equipo necesarios para la correcta ejecucion delos trabajos"';
		$data[19]["precio_unitario"] = 286.259999705783;
		$data[19]["cantidad"] = (1000*($this->options["A"]*$this->options["B"]))*0.2;
		
		$data[20]["concepto"] = '"Acarreo en camion, de concreto asfaltico templado para bacheo (maximo 20 m3), kilometros subsecuentes."';
		$data[20]["precio_unitario"] = 16.3000019614381;
		$data[20]["cantidad"] = (((0.2*$data[17]["cantidad"])/12.5)*(0.9375))*20;
		
		$data[21]["concepto"] = '"Riego de sello a base de Slurry Seal, abase de emulsion asfaltica ecr-mod con aditivos quimicos compatible con agua y agregado arena fina tipo I, como acabado final en ciclovia, incluye: materiales, manodeobray equipoy herramientamenor"';
		$data[21]["precio_unitario"] = 55.23;
		$data[21]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[22]["concepto"] = '"Renivelacion de brocales de concreto."';
		$data[22]["precio_unitario"] = 374.84;
		$data[22]["cantidad"] = $this->options["A"]*15;
		
		$data[23]["concepto"] = '"Renivelacion de tapa de registro de 1.00 x 0.65 m, incluye: concreto fc = 150 kg/cm2, agregado maximo de 20 mm."';
		$data[23]["precio_unitario"] = 524.6;
		$data[23]["cantidad"] = $this->options["A"]*20;
		
		$data[24]["concepto"] = '"Renivelacion de coladera de banqueta con brocales de concreto o fierro fundido, incluye: muro de tabique recocido, aplanado con mortero cemento arena 1:3."';
		$data[24]["precio_unitario"] = 313.08;
		$data[24]["cantidad"] = $this->options["A"]*4;
		
		$data[25]["concepto"] = '"Renivelacion de coladera de piso de una rejilla, incluye: muro de tabique recocido y aplanado con mortero cemento-arena 1:3."';
		$data[25]["precio_unitario"] = 269.82;
		$data[25]["cantidad"] = $this->options["A"]*5;
		
		$data[26]["concepto"] = '"Suministro  e  instalacion  de  registro  de  polietileno  de  alta  resistencia,  para  pluvial "';
		$data[26]["precio_unitario"] = 1988.66;
		$data[26]["cantidad"] = $this->options["A"]*1;
		
		$data[27]["concepto"] = '"Suministro y colocacion de marco y rejilla de polietileno alta resistencia boca de tormenta de 66 x 55 cm."';
		$data[27]["precio_unitario"] = 3693.42;
		$data[27]["cantidad"] = $this->options["A"]*2;
		
		$data[28]["concepto"] = '"Suministro e instalacion de marco con tapa de polietileno alta resistencia de 5x 50, para caja de valvula."';
		$data[28]["precio_unitario"] = 2027.44;
		$data[28]["cantidad"] = $this->options["A"]*3;
		
		$data[29]["concepto"] = '"Suministro y colocacion de brocal y tapa de polietileno alta resistencia, para pozo de visita."';
		$data[29]["precio_unitario"] = 2805.9;
		$data[29]["cantidad"] = $this->options["A"]*3;
		
		$data[30]["concepto"] = '"Tubo de PVC tipo sanitario union cementar, extremos lisos de 200 mm de diametro."';
		$data[30]["precio_unitario"] = 215.82;
		$data[30]["cantidad"] = $this->options["A"]*15;
		
		$data[31]["concepto"] = '"Dispositivo DPP-1 Barrera Plastica Vehicular de proteccion vial fabricada en polietileno de media densidad color: naranja, medidas: l: 156 cm, a: 59.5 cm, h: 85 cm, capacidad de llenado: 72 cm3, parausar vacia, con arena a una tercera parte de su capacidad."';
		$data[31]["precio_unitario"] = 3232.01;
		$data[31]["cantidad"] = $this->options["A"]*50;
		
		$data[32]["concepto"] = '"Trafisit, fabricado en polietileno medidas: diametro de base: 50 cm, diametro superior: 43 cm, altura: 107 cm, con 2 cintas reflejantes grado ingenieria sin base"';
		$data[32]["precio_unitario"] = 718.62;
		$data[32]["cantidad"] = $this->options["A"]*50;
		
		$data[33]["concepto"] = '"Pintado de raya de cruce de peatones 40 cm de ancho con pintura coldplastic color blanco con reflejante (microesferas)."';
		$data[33]["precio_unitario"] = 80;
		$data[33]["cantidad"] = (7+$this->options["B"]-2.5)*12;
		
		$data[34]["concepto"] = '"Pintado de raya de alto con pintura coldplastic color blanco en superficies de rodamiento para definir el alto de los vehiculos en los cruces, de 60 cm de ancho. "';
		$data[34]["precio_unitario"] = 120;
		$data[34]["cantidad"] = (7+$this->options["B"]-2.5)*$this->options["F"]*2;
		
		$data[35]["concepto"] = '"Pintado de pictograma area de espera ciclista y motociclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de espera en alto de vialidades, de dimensiones de 3.20 m de altura por 1.80 m de ancho."';
		$data[35]["precio_unitario"] = 2*384.25;
		$data[35]["cantidad"] = 2*$this->options["F"];
		
		$data[36]["concepto"] = '"Pintado de raya sencilla para delimitar arroyo vial con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho "';
		$data[36]["precio_unitario"] = 20;
		$data[36]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[37]["concepto"] = '"Pintado de raya discontinua para delimitar carriles de circulacion con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho por 2.5 metros de largo"';
		$data[37]["precio_unitario"] = 20;
		$data[37]["cantidad"] = ($this->options["D"]-1)*(300*$this->options["A"])+(30*$this->options["F"]);
		
		$data[38]["concepto"] = '"Pintado de pictograma carril exclusivo bicicleta, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de uso exclusivo para bicicletas, de dimensiones de 6.10 m de altura por 1.50 m de ancho."';
		$data[38]["precio_unitario"] = 1968.93;
		$data[38]["cantidad"] = 2*$this->options["F"];
		
		$data[39]["concepto"] = '"Pintado de flecha de sentido (frente y vuelta a la derecha/izquierda) con pintura coldplastic color  blanco y reflejante (microesferas), en superficies de rodamiento para indicar direccion en vialidades con velocidades de 30 km/hora o menores, de dimensiones de flecha de 5.00 m de longitud, 2.70 m de ancho y 0.40 m de base."';
		$data[39]["precio_unitario"] = 430;
		$data[39]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[40]["concepto"] = '"Pintado de pictograma y raya para parada de transporte publico, con pintura pintura colsplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area deparada de transporte publico, (BUS) de dimensiones de 1.60 m de altura por 1.88 m de ancho. y franjas de 10 cmanchopor 20 mts delong. franjade 60 cmpor 3.20 long."';
		$data[40]["precio_unitario"] = 1377.52;
		$data[40]["cantidad"] = $this->options["F"]/3;
		
		$data[41]["concepto"] = '"Pintado de buffer para apertura de puertezuelas de 10 cm cada una con rayas diagonales, pintura coldplastic color blanco y reflejante (microesferas),  en superficies de rodamiento."';
		$data[41]["precio_unitario"] = 90;
		$data[41]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[42]["concepto"] = '"Pintado de pictograma de control de velocidad, con pintura coldplastic color blanco  y  reflejante (microesferas) en superficies  de rodamiento para  vialidades  con velocidades menores a 100 km/hora, de dimensiones de 4.00 m de altura por 2.00 m de ancho."';
		$data[42]["precio_unitario"] = 700;
		$data[42]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[43]["concepto"] = '"Pintado de raya para cruces ciclistas, con pintura coldplastic color verde y reflejante (microesferas) en superficies de rodamiento para definir el ancho de carril exclusivo ciclista encruces, de 40 cm de ancho."';
		$data[43]["precio_unitario"] = 256.63;
		$data[43]["cantidad"] = 100*$this->options["F"];
		
		$data[44]["concepto"] = '"Pintado de pictograma cruce ciclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el cruce de ciclistas en vialidades, de dimensiones de 2.10 m de altura por 1.18 m de ancho."';
		$data[44]["precio_unitario"] = 322.68;
		$data[44]["cantidad"] = $this->options["F"];
		
		$data[45]["concepto"] = '"Pintado en guarnicion de concreto, con pintura esmalte 100 biosensecolor amarilla y reflejante (microesferas) para indicar el area de espera en alto de vialidades de 15 cm de corona y de 0 a 30 cmde altura."';
		$data[45]["precio_unitario"] = 47.55;
		$data[45]["cantidad"] = 60*$this->options["F"];
		
		$data[46]["concepto"] = '"Pintado  de  raya  sencilla  para indicar estacionamiento con  pintura coldplastic  color  blanco  y  reflejante (microesferas), en superficies de rodamiento,  de 10 cm de ancho y de 50 cmx 50 cm."';
		$data[46]["precio_unitario"] = 22.5;
		$data[46]["cantidad"] = 150*$this->options["F"];
		
		$data[47]["concepto"] = '"Senal informativa de servicios via ciclista 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[47]["precio_unitario"] = 1797.23;
		$data[47]["cantidad"] = $this->options["F"];
		
		$data[48]["concepto"] = '"Senal informativa de servicios parada de transporte publico 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[48]["precio_unitario"] = 1797.23;
		$data[48]["cantidad"] = $this->options["F"]/3;
		
		$data[49]["concepto"] = '"Senal  informativa de servicios para estacionarse 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor. "';
		$data[49]["precio_unitario"] = 1834.81;
		$data[49]["cantidad"] = 2*$this->options["F"];
		
		$data[50]["concepto"] = '"Senal  restrictiva de velocidad 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor. "';
		$data[50]["precio_unitario"] = 1834.81;
		$data[50]["cantidad"] = $this->options["F"];
		
		$data[51]["concepto"] = '"Senal preventiva de cruce ciclista 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[51]["precio_unitario"] = 1696.17;
		$data[51]["cantidad"] = $this->options["F"];
		
		$data[52]["concepto"] = '"Senal preventiva de motocicletas 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[52]["precio_unitario"] = 1834.81;
		$data[52]["cantidad"] = $this->options["F"];
		
		$data[53]["concepto"] = '"Dispositivo diverso indicador de obstaculo caramelo (DD-5c) de 60 cm x 30 cm  fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor, sin poste."';
		$data[53]["precio_unitario"] = 739.63;
		$data[53]["cantidad"] = $this->options["A"]/3;
		
		$data[54]["concepto"] = '"Senal preventiva de apertutra de portezuela 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[54]["precio_unitario"] = 1696.17;
		$data[54]["cantidad"] = $this->options["F"];
		
		$data[55]["concepto"] = '"Hito abatible de polietileno de alta densidad de 0.82 m de alto, diametro de 10.7 m Y 19.5 en la base, temperatura de deflexion por calor a 80°  los trabajos incluyen: la fabricacion en planta, la carga, acarreo al sitio de la obra, trazo y nivelacion, perforacion es para fijacion, colocacion de piezas de concreto y pernos con resina, los materiales, mano de obra, herramienta y equipo necesario para su correcta ejecucion."';
		$data[55]["precio_unitario"] = 417*1.25;
		$data[55]["cantidad"] = 166*$this->options["A"];
		
		$data[56]["concepto"] = '"Suministro y colocacion de bolardo fabricado en polietileno de una sola pieza con tubo de acero interno, accesorio para delimitar zonas peatonales banquetas, camellones, diseno modernoy anguardistadealtaresistencia, medidas diametro 15 cm., altura 130 cm."';
		$data[56]["precio_unitario"] = 1296.73;
		$data[56]["cantidad"] = 12*$this->options["F"];
		
		$data[57]["concepto"] = '"Semaforo ciclista con carcasa fabricada en policarbonato de alto impacto 2 secciones (R,V) simulan la forma de una bicicleta pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';	
		$data[57]["precio_unitario"] = 4800+52600;
		$data[57]["cantidad"] = $this->options["J"];
		
		$data[58]["concepto"] = '"Semaforo peatonal incandescente de 20 cms, Fabricados en policarbonato, fundidos a presion segun la especificacion de aleacion SC-848 (n.380), Cuerpo fundido en una sola pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[58]["precio_unitario"] = 9600+52600;
		$data[58]["cantidad"] = 4*$this->options["J"];
		
		$data[59]["concepto"] = '"Estacionamiento para bicicleta tipo U invertida a base de tubo redondo de acero galvanizado con diametro de 2, cedula 30 sin costura, con senalamiento de placa de acero de 15 X 20 cm X 1/8 de espesor con senal informativa de doble vista hecha en material reflejante grado ingenieria. Incluye dos anclas de barra de acero pulido tipo cold-roll de 20 cm de largo y 1/2 de diametro. El precio Incluye el equipo y la herramienta necesarios para la correcta ejecucion de los trabajos."';
		$data[59]["precio_unitario"] = 3000;
		$data[59]["cantidad"] = $this->options["K"];
		
		$result = $this->getImporte($data);
		
		$subtotal = 0;
		for($i = 1; $i <= 10; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_preliminares"] = $subtotal;
		
		$subtotal = 0;
		for($i = 11; $i <= 16; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_banquetas_guarniciones"] = $subtotal;
		
		$subtotal = 0;
		for($i = 17; $i <= 21; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_pavimentos"] = $subtotal;
		
		$subtotal = 0;
		for($i = 22; $i <= 30; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_alcantarillado"] = $subtotal;
		
		$subtotal = 0;
		for($i = 31; $i <= 32; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_obra"] = $subtotal;
		
		$subtotal = 0;
		for($i = 33; $i <= 46; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_horizontal"] = $subtotal;
		
		$subtotal = 0;
		for($i = 47; $i <= 54; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_vertical"] = $subtotal;
		
		$subtotal = 0;
		for($i = 55; $i <= 58; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_dispositivos_transito"] = $subtotal;
		
		$result["subtotal_mobiliario"] = $result[59]["importe"];
		
		return $result;
	}
	
	//{"estado":6,"municipio":2,"infraestructura":"BB","A":1,"B":15,"C":1,"D":3,"E":4,"F":8,"G":8,"H":0,"I":0,"J":2,"K":15,"L":"SI","M":"SI","N":"SI"}
	/*Carril compartido ciclista con transporte publico (BusBici)*/
	public function getBB() {
		$data = null;
		
		$data[1]["concepto"] = '"Trazo y nivelacion de plazas, andadores y parques, con equipo de topografia primeros 10000 m2."';
		$data[1]["precio_unitario"] = 2.24;
		$data[1]["cantidad"] = 1000*$this->options["A"]*$this->options["B"];
		
		$data[2]["concepto"] = '"Demolicion por medios manuales de guarnicion y banqueta de concreto simple."';
		$data[2]["precio_unitario"] = 336.65;
		$data[2]["cantidad"] = (1.3*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[3]["concepto"] = '"Demolicion por medios manuales de pavimento de concreto asfaltico sin afectar base, para trabajos de bacheo, medido en banco. "';
		$data[3]["precio_unitario"] = 328.24;
		$data[3]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[4]["concepto"] = '"Carga, acarreo en carretilla y descarga a primera estacion de 20 m, de material producto de demolicion, medido en banco."';
		$data[4]["precio_unitario"] = 63.12;
		$data[4]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);

		$data[5]["concepto"] = '"Acarreo en carretilla de material, producto de demolicion, a estaciones subsecuentes de 20 m."';
		$data[5]["precio_unitario"] = 22.31;
		$data[5]["cantidad"] = 2*$data[4]["cantidad"];
		
		$data[6]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga, de material de demolicion de concreto hidraulico, volumen medido colocado."';
		$data[6]["precio_unitario"] = 107.01;
		$data[6]["cantidad"] = (1.3*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[7]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto, kilomeros subsecuentes, zona urbana. "';
		$data[7]["precio_unitario"] = 10.16;
		$data[7]["cantidad"] = 20*$data[6]["cantidad"];
		
		$data[8]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga de material de demolicion de carpeta asfaltica, volumen medido colocado."';
		$data[8]["precio_unitario"] = 99.93;
		$data[8]["cantidad"] = (3.85*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[9]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto asfaltico, kilometros subsecuentes, zona urbana."';
		$data[9]["precio_unitario"] = 9.15;
		$data[9]["cantidad"] = 20*$data[8]["cantidad"];
		
		$data[10]["concepto"] = '"Desmantelamiento de poste de esquina de 60 mm de diametro en cerca de 2.00 m de altura, incluye: capucha, accesorios y demolicion de cimentacion."';
		$data[10]["precio_unitario"] = 53.3;
		$data[10]["cantidad"] = $this->options["E"]*$this->options["A"];
		
		$data[11]["concepto"] = '"Preparacion, conformacion y compactacion de subrasante para banquetas, en forma manual, incluye incorporacion de agua."';
		$data[11]["precio_unitario"] = 12.49;
		$data[11]["cantidad"] = 72.5*$this->options["G"];
		
		$data[12]["concepto"] = '"Suministro y colocacion de tepetate de 10 cm de espesor compactado al 85% proctor, para desplante de banqueta, incluye incorporacion de agua."';
		$data[12]["precio_unitario"] = 30.75;
		$data[12]["cantidad"] = (1000*$this->options["H"]*$this->options["I"]);
		
		$data[13]["concepto"] = '"Banqueta de 10 cm de espesor de concreto hidraulico resistencia normal f c= 150 kg/cm2,colados en cuadros de 0.80 x 1.60 m, alternados , acabado color negro y blanco deslavado conacabado, incluye: cimbrado, descimbrado, lavado, materiales y mano de obra"';
		$data[13]["precio_unitario"] = 396.27;
		$data[13]["cantidad"] = $data[11]["cantidad"]+$data[12]["cantidad"];
		
		$data[14]["concepto"] = '"Acabado con volteador en las aristas de banquetas, en tramos alternados."';
		$data[14]["precio_unitario"] = 11.97;
		$data[14]["cantidad"] = (92.4*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[15]["concepto"] = '"Acabado con volteador en las aristas y separacion de placas de banqueta, en tramos alternados."';
		$data[15]["precio_unitario"] = 11.97;
		$data[15]["cantidad"] = ((1000*$this->options["H"])/3)*$this->options["I"];
		
		$data[16]["concepto"] = '"Guarnicion de concreto hidraulico resistencia normal f c= 200 kg/cm2, seccion trapezoidal de 15 x 20 x 35 cm"';
		$data[16]["precio_unitario"] = 176.78;
		$data[16]["cantidad"] = (48.16*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[17]["concepto"] = '"Barrido de base previo al riego de impregnacion"';
		$data[17]["precio_unitario"] = 1.71;
		$data[17]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[18]["concepto"] = '"Corte con sierra en pavimento de concreto asfaltico, con profundidad de 2.5 cm a 5.00 cm"';
		$data[18]["precio_unitario"] = 8.42;
		$data[18]["cantidad"] = ((0.20*$data[17]["cantidad"])/12.5)*15;
		
		$data[19]["concepto"] = '"Bacheo de 7.5 cm de espesor con concreto asfaltico compactado al 90% de su densidad teorica maxima, con riego de liga e impregnacion, incluye: los materiales, la mano de obra, preparacion de la superficie, la herramienta y el equipo necesarios para la correcta ejecucion delos trabajos"';
		$data[19]["precio_unitario"] = 286.259999705783;
		$data[19]["cantidad"] = (1000*($this->options["A"]*$this->options["B"]))*0.2;
		
		$data[20]["concepto"] = '"Acarreo en camion, de concreto asfaltico templado para bacheo (maximo 20 m3), kilometros subsecuentes."';
		$data[20]["precio_unitario"] = 16.3000019614381;
		$data[20]["cantidad"] = (((0.2*$data[17]["cantidad"])/12.5)*(0.9375))*20;
		
		$data[21]["concepto"] = '"Riego de sello a base de Slurry Seal, abase de emulsion asfaltica ecr-mod con aditivos quimicos compatible con agua y agregado arena fina tipo I, como acabado final en ciclovia, incluye: materiales, manodeobray equipoy herramientamenor"';
		$data[21]["precio_unitario"] = 55.23;
		$data[21]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[22]["concepto"] = '"Renivelacion de brocales de concreto."';
		$data[22]["precio_unitario"] = 374.84;
		$data[22]["cantidad"] = $this->options["A"]*15;
		
		$data[23]["concepto"] = '"Renivelacion de tapa de registro de 1.00 x 0.65 m, incluye: concreto f c = 150 kg/cm2, agregado maximo de 20 mm."';
		$data[23]["precio_unitario"] = 524.6;
		$data[23]["cantidad"] = $this->options["A"]*20;
		
		$data[24]["concepto"] = '"Renivelacion de coladera de banqueta con brocales de concreto o fierro fundido, incluye: muro de tabique recocido, aplanado con mortero cemento arena 1:3."';
		$data[24]["precio_unitario"] = 313.08;
		$data[24]["cantidad"] = $this->options["A"]*4;
		
		$data[25]["concepto"] = '"Renivelacion de coladera de piso de una rejilla, incluye: muro de tabique recocido y aplanado con mortero cemento-arena 1:3."';
		$data[25]["precio_unitario"] = 269.82;
		$data[25]["cantidad"] = $this->options["A"]*5;
		
		$data[26]["concepto"] = '"Suministro  e  instalacion  de  registro  de  polietileno  de  alta  resistencia,  para  pluvial "';
		$data[26]["precio_unitario"] = 1988.66;
		$data[26]["cantidad"] = $this->options["A"]*1;
		
		$data[27]["concepto"] = '"Suministro y colocacion de marco y rejilla de polietileno alta resistencia boca de tormenta de 66 x 55 cm."';
		$data[27]["precio_unitario"] = 3693.42;
		$data[27]["cantidad"] = $this->options["A"]*2;
		
		$data[28]["concepto"] = '"Suministro e instalacion de marco con tapa de polietileno alta resistencia de 5x 50, para caja de valvula."';
		$data[28]["precio_unitario"] = 2027.44;
		$data[28]["cantidad"] = $this->options["A"]*3;
		
		$data[29]["concepto"] = '"Suministro y colocacion de brocal y tapa de polietileno alta resistencia, para pozo de visita."';
		$data[29]["precio_unitario"] = 2805.9;
		$data[29]["cantidad"] = $this->options["A"]*3;
		
		$data[30]["concepto"] = '"Tubo de PVC tipo sanitario union cementar, extremos lisos de 200 mm de diametro."';
		$data[30]["precio_unitario"] = 215.82;
		$data[30]["cantidad"] = $this->options["A"]*15;
		
		$data[31]["concepto"] = '"Dispositivo DPP-1 Barrera Plastica Vehicular de proteccion vial fabricada en polietileno de media densidad color: naranja, medidas: l: 156 cm, a: 59.5 cm, h: 85 cm, capacidad de llenado: 72 cm3, parausar vacia, con arena a una tercera parte de su capacidad."';
		$data[31]["precio_unitario"] = 3232.01;
		$data[31]["cantidad"] = $this->options["A"]*50;
		
		$data[32]["concepto"] ='"Trafisit, fabricado en polietileno medidas: diametro de base: 50 cm, diametro superior: 43 cm, altura: 107 cm, con 2 cintas reflejantes grado ingenieria sin base"';
		$data[32]["precio_unitario"] = 718.62;
		$data[32]["cantidad"] = $this->options["A"]*50;
		
		$data[33]["concepto"] = '"Pintado de raya de cruce de peatones 40 cm de ancho con pintura coldplastic color blanco con reflejante (microesferas)."';
		$data[33]["precio_unitario"] = 80;
		$data[33]["cantidad"] = (7+$this->options["B"])*12;
		
		$data[34]["concepto"] = '"Pintado de raya de alto con pintura coldplastic color blanco en superficies de rodamiento para definir el alto de los vehiculos en los cruces, de 60 cm de ancho. "';
		$data[34]["precio_unitario"] = 120;
		$data[34]["cantidad"] = (7+$this->options["B"])*$this->options["F"]*2;
		
		$data[35]["concepto"] = '"Pintado de pictograma area de espera ciclista y motociclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de espera en alto de vialidades, de dimensiones de 3.20 m de altura por 1.80 m de ancho."';
		$data[35]["precio_unitario"] = 2*384.25;
		$data[35]["cantidad"] = 2*$this->options["F"];
		
		$data[36]["concepto"] = '"Pintado de raya sencilla para delimitar arroyo vial con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho "';
		$data[36]["precio_unitario"] = 20;
		$data[36]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[37]["concepto"] = '"Pintado de raya discontinua para delimitar carriles de circulacion con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho por 2.5 metros de largo"';
		$data[37]["precio_unitario"] = 20;
		$data[37]["cantidad"] = ($this->options["D"]-1)*(300*$this->options["A"])+(30*$this->options["F"]);
		
		$data[38]["concepto"] = '"Pintado de pictograma de carril de transporte publico compartido con bicicleta, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de uso exclusivo para bicicletas, de dimensiones de 13.20 m de altura por 2.40 m de ancho."';
		$data[38]["precio_unitario"] = 1968.93;
		$data[38]["cantidad"] = 2*$this->options["F"];
		
		$data[39]["concepto"] = '"Pintado de flecha de sentido (frente y vuelta a la derecha/izquierda) con pintura coldplastic color  blanco y reflejante (microesferas), en superficies de rodamiento para indicar direccion en vialidades con velocidades de 30 km/hora o menores, de dimensiones de flecha de 5.00 m de longitud, 2.70 m de ancho y 0.40 m de base."';
		$data[39]["precio_unitario"] = 430;
		$data[39]["cantidad"] = ($this->options["D"]-1)*$this->options["F"];
		
		$data[40]["concepto"] = '"Pintado de pictograma y raya para parada de transporte publico, con pintura pintura colsplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area deparada de transporte publico, (BUS) de dimensiones de 1.60 m de altura por 1.88 m de ancho. y franjas de 10 cmanchopor 20 mts delong. franjade 60 cmpor 3.20 long."';
		$data[40]["precio_unitario"] = 1377.52;
		$data[40]["cantidad"] = $this->options["F"]/3;
		
		$data[41]["concepto"] = '"Pintado de raya doble de 10 cm cada una con pintura coldplastic color blanco y reflejante (microesferas),  en superficies de rodamiento,  para indicar  elemento de confinamiento."';
		$data[41]["precio_unitario"] = 60;
		$data[41]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[42]["concepto"] = '"Pintado de pictograma de control de velocidad, con pintura coldplastic color blanco  y  reflejante (microesferas) en superficies  de rodamiento para  vialidades  con velocidades menores a 100 km/hora, de dimensiones de 4.00 m de altura por 2.00 m de ancho."';
		$data[42]["precio_unitario"] = 700;
		$data[42]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[43]["concepto"] = '"Pintado de raya para cruces ciclistas, con pintura coldplastic color verde y reflejante (microesferas) en superficies de rodamiento para definir el ancho de carril exclusivo ciclista encruces, de 40 cm de ancho."';
		$data[43]["precio_unitario"] = 256.63;
		$data[43]["cantidad"] = 100*$this->options["F"];
		
		$data[44]["concepto"] = '"Pintado de pictograma cruce ciclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el cruce de ciclistas en vialidades, de dimensiones de 2.10 m de altura por 1.18 m de ancho."';
		$data[44]["precio_unitario"] = 322.68;
		$data[44]["cantidad"] = $this->options["F"];
		
		$data[45]["concepto"] = '"Pintado en guarnicion de concreto, con pintura esmalte 100 biosensecolor amarilla y reflejante (microesferas) para indicar el area de espera en alto de vialidades de 15 cm de corona y de 0 a 30 cmde altura."';
		$data[45]["precio_unitario"] = 47.55;
		$data[45]["cantidad"] = 60*$this->options["F"];
		
		$data[46]["concepto"] = '"Senal informativa de servicios via ciclista compartida con transporte publico 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[46]["precio_unitario"] = 1797.23;
		$data[46]["cantidad"] = $this->options["F"];
		
		$data[47]["concepto"] = '"Senal informativa de servicios parada de transporte publico 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[47]["precio_unitario"] = 1797.23;
		$data[47]["cantidad"] = $this->options["F"]/3;
		
		$data[48]["concepto"] = '"Senal  restrictiva de prohibido estacionarse 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor. "';
		$data[48]["precio_unitario"] = 1834.81;
		$data[48]["cantidad"] = 2*$this->options["F"];
		
		$data[49]["concepto"] = '"Senal  restrictiva de velocidad 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor."';
		$data[49]["precio_unitario"] = 1834.81;
		$data[49]["cantidad"] = $this->options["F"];
		
		$data[50]["concepto"] = '"Senal preventiva de cruce ciclista 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[50]["precio_unitario"] = 1696.17;
		$data[50]["cantidad"] = $this->options["F"];
		
		$data[51]["concepto"] = '"Senal preventiva de motocicletas 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[51]["precio_unitario"] = 1834.81;
		$data[51]["cantidad"] = $this->options["F"];
		
		$data[52]["concepto"] = '"Dispositivo diverso indicador de obstaculo caramelo (DD-5c) de 60 cm x 30 cm  fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor, sin poste."';
		$data[52]["precio_unitario"] = 739.63;
		$data[52]["cantidad"] = $this->options["A"]/3;
		
		$data[53]["concepto"] = '"Suministro y colocacion de elemento confinador de carril confibici, fabricado en polietileno de media densidad, moldeado por proceso de inyeccion a baja presion, color amarillo, medidas: largo 180 cm., ancho 15 cm., altura 13 cm., reflejante tipo microesferaen ambos extremos y 2 Franjas laterales (color amarillo), con nervaduras (superficie antiderrapante) del lado de la rampa para las bicicletas, con logotipo en bajo relieve bicicleta, fijacion con 6 tornillos 1/2 x 12 y resinaepoxica."';
		$data[53]["precio_unitario"] = 1850;
		$data[53]["cantidad"] = 215*$this->options["A"];
		
		$data[54]["concepto"] = '"Hito abatible de polietileno de alta densidad de 0.82 m de alto, diametro de 10.7 m Y 19.5 en la base, temperatura de deflexion por calor a 80°  los trabajos incluyen: la fabricacion en planta, la carga, acarreo al sitio de la obra, trazo y nivelacion, perforacion es para fijacion, colocacion de piezas de concreto y pernos con resina, los materiales, mano de obra, herramienta y equipo necesario para su correcta ejecucion."';
		$data[54]["precio_unitario"] = 417*1.25;
		$data[54]["cantidad"] = 12*$this->options["F"];
		
		$data[55]["concepto"] = '"Suministro y colocacion de botones blancos, con dos reflejantes, asentado con pegamento epoxico"';
		$data[55]["precio_unitario"] = 62.41;
		$data[55]["cantidad"] = ((133*$this->options["A"])*($this->options["D"]-1))+(20*$this->options["F"]);
		
		$data[56]["concepto"] = '"Suministro y colocacion de bolardo fabricado en polietileno de una sola pieza con tubo de acero interno, accesorio para delimitar zonas peatonales banquetas, camellones, diseno modernoy anguardistadealtaresistencia, medidas diametro 15 cm., altura 130 cm."';
		$data[56]["precio_unitario"] = 1296.73;
		$data[56]["cantidad"] = 8*$this->options["F"];
		
		$data[57]["concepto"] = '"Construccion insitu de reductor de velocidad tipo cojin de concreto asfaltico, medidas 4 m de longitud por 1.90 m de ancho. "';
		$data[57]["precio_unitario"] = 149.75;
		$data[57]["cantidad"] = 114*$this->options["A"];
		
		$data[58]["concepto"] = '"Semaforo ciclista con carcasa fabricada en policarbonato de alto impacto 2 secciones (R,V) simulan la forma de una bicicleta pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[58]["precio_unitario"] = 4800+52600;
		$data[58]["cantidad"] = $this->options["J"];
		
		$data[59]["concepto"] = '"Semaforo peatonal incandescente de 20 cms, Fabricados en policarbonato, fundidos a presion segun la especificacion de aleacion SC-848 (n.380), Cuerpo fundido en una sola pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[59]["precio_unitario"] = 9600+52600;
		$data[59]["cantidad"] = 4*$this->options["J"];
		
		$data[60]["concepto"] = '"Estacionamiento para bicicleta tipo U invertida a base de tubo redondo de acero galvanizado con diametro de 2, cedula 30 sin costura, con senalamiento de placa de acero de 15 X 20 cm X 1/8 de espesor con senal informativa de doble vista hecha en material reflejante grado ingenieria. Incluye dos anclas de barra de acero pulido tipo cold-roll de 20 cm de largo y 1/2 de diametro. El precio Incluye el equipo y la herramienta necesarios para la correcta ejecucion de los trabajos."';
		$data[60]["precio_unitario"] = 3000;
		$data[60]["cantidad"] = $this->options["K"];
		
		$result = $this->getImporte($data);
		
		$subtotal = 0;
		for($i = 1; $i <= 10; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_preliminares"] = $subtotal;
		
		$subtotal = 0;
		for($i = 11; $i <= 16; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_banquetas_guarniciones"] = $subtotal;
		
		$subtotal = 0;
		for($i = 17; $i <= 21; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_pavimentos"] = $subtotal;
		
		$subtotal = 0;
		for($i = 22; $i <= 30; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_alcantarillado"] = $subtotal;
		
		$subtotal = 0;
		for($i = 31; $i <= 32; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_obra"] = $subtotal;
		
		$subtotal = 0;
		for($i = 33; $i <= 45; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_horizontal"] = $subtotal;
		
		$subtotal = 0;
		for($i = 46; $i <= 52; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_vertical"] = $subtotal;
		
		$subtotal = 0;
		for($i = 53; $i <= 59; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_dispositivos_transito"] = $subtotal;
		
		$result["subtotal_mobiliario"] = $result[60]["importe"];
		
		return $result;
	}
	
	//{"estado":6,"municipio":2,"infraestructura":"CICA","A":1,"B":6,"C":1,"D":3,"E":4,"F":8,"G":8,"H":0,"I":0,"J":2,"K":15,"L":"SI","M":"SI","N":"SI"}
	/*Ciclocarril*/
	public function getCICA() {
		$data = null;

		$data[1]["concepto"] = '"Trazo y nivelacion de plazas, andadores y parques, con equipo de topografia primeros 10000 m2."';
		$data[1]["precio_unitario"] = 2.24;
		$data[1]["cantidad"] = 1000*$this->options["A"]*$this->options["B"];
		
		$data[2]["concepto"] = '"Demolicion por medios manuales de guarnicion y banqueta de concreto simple."';
		$data[2]["precio_unitario"] = 336.65;
		$data[2]["cantidad"] = (2.6*$this->options["G"])+(37.5*$this->options["H"]);
		
		$data[3]["concepto"] = '"Demolicion por medios manuales de pavimento de concreto asfaltico sin afectar base, para trabajos de bacheo, medido en banco. "';
		$data[3]["precio_unitario"] = 328.24;
		$data[3]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[4]["concepto"] = '"Carga, acarreo en carretilla y descarga a primera estacion de 20 m, de material producto de demolicion, medido en banco."';
		$data[4]["precio_unitario"] = 63.12;
		$data[4]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);

		$data[5]["concepto"] = '"Acarreo en carretilla de material, producto de demolicion, a estaciones subsecuentes de 20 m."';
		$data[5]["precio_unitario"] = 22.31;
		$data[5]["cantidad"] = 2*$data[4]["cantidad"];
		
		$data[6]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga, de material de demolicion de concreto hidraulico, volumen medido colocado."';
		$data[6]["precio_unitario"] = 107.01;
		$data[6]["cantidad"] = (2.6*$this->options["G"])+(37.5*$this->options["H"]);
		

		$data[7]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto, kilomeros subsecuentes, zona urbana. "';
		$data[7]["precio_unitario"] = 10.16;
		$data[7]["cantidad"] = 20*$data[6]["cantidad"];
		
		$data[8]["concepto"] = '"Carga manual, acarreo en camion al primer kilometro y descarga de material de demolicion de carpeta asfaltica, volumen medido colocado."';
		$data[8]["precio_unitario"] = 99.93;
		$data[8]["cantidad"] = (7.7*$this->options["G"])+(((1000*$this->options["H"])+($this->options["F"]*$this->options["I"]))*0.875);
		
		$data[9]["concepto"] = '"Acarreo en camion, de material de demolicion de concreto asfaltico, kilometros subsecuentes, zona urbana."';
		$data[9]["precio_unitario"] = 9.15;
		$data[9]["cantidad"] = 20*$data[8]["cantidad"];
		
		$data[10]["concepto"] = '"Desmantelamiento de poste de esquina de 60 mm de diametro en cerca de 2.00 m de altura, incluye: capucha, accesorios y demolicion de cimentacion."';
		$data[10]["precio_unitario"] = 53.3;
		$data[10]["cantidad"] = $this->options["E"]*$this->options["A"];
		
		$data[11]["concepto"] = '"Preparacion, conformacion y compactacion de subrasante para banquetas, en forma manual, incluye incorporacion de agua."';
		$data[11]["precio_unitario"] = 12.49;
		$data[11]["cantidad"] = 145*$this->options["G"];
		
		$data[12]["concepto"] = '"Suministro y colocacion de tepetate de 10 cm de espesor compactado al 85% proctor, para desplante de banqueta, incluye incorporacion de agua."';
		$data[12]["precio_unitario"] = 30.75;
		$data[12]["cantidad"] = (1000*$this->options["H"]*$this->options["I"]);
		
		$data[13]["concepto"] = '"Banqueta de 10 cm de espesor de concreto hidraulico resistencia normal f c= 150 kg/cm2,colados en cuadros de 0.80 x 1.60 m, alternados , acabado color negro y blanco deslavado conacabado, incluye: cimbrado, descimbrado, lavado, materiales y mano de obra"';
		$data[13]["precio_unitario"] = 396.27;
		$data[13]["cantidad"] = $data[11]["cantidad"]+$data[12]["cantidad"];
		
		$data[14]["concepto"] = '"Acabado con volteador en las aristas de banquetas, en tramos alternados."';
		$data[14]["precio_unitario"] = 11.97;
		$data[14]["cantidad"] = (184.8*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[15]["concepto"] = '"Acabado con volteador en las aristas y separacion de placas de banqueta, en tramos alternados."';
		$data[15]["precio_unitario"] = 11.97;
		$data[15]["cantidad"] = ((1000*$this->options["H"])/3)*$this->options["I"];
		
		$data[16]["concepto"] = '"Guarnicion de concreto hidraulico resistencia normal f c= 200 kg/cm2, seccion trapezoidal de 15 x 20 x 35 cm"';
		$data[16]["precio_unitario"] = 176.78;
		$data[16]["cantidad"] = (96.32*$this->options["G"])+(1000*$this->options["H"])+($this->options["F"]*$this->options["I"]);
		
		$data[17]["concepto"] = '"Barrido de base previo al riego de impregnacion"';
		$data[17]["precio_unitario"] = 1.71;
		$data[17]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[18]["concepto"] = '"Corte con sierra en pavimento de concreto asfaltico, con profundidad de 2.5 cm a 5.00 cm"';
		$data[18]["precio_unitario"] = 8.42;
		$data[18]["cantidad"] = ((0.20*$data[17]["cantidad"])/12.5)*15;
		
		$data[19]["concepto"] = '"Bacheo de 7.5 cm de espesor con concreto asfaltico compactado al 90% de su densidad teorica maxima, con riego de liga e impregnacion, incluye: los materiales, la mano de obra, preparacion de la superficie, la herramienta y el equipo necesarios para la correcta ejecucion delos trabajos"';
		$data[19]["precio_unitario"] = 286.259999705783;
		$data[19]["cantidad"] = (1000*($this->options["A"]*$this->options["B"]))*0.2;
		
		$data[20]["concepto"] = '"Acarreo en camion, de concreto asfaltico templado para bacheo (maximo 20 m3), kilometros subsecuentes."';
		$data[20]["precio_unitario"] = 16.3000019614381;
		$data[20]["cantidad"] = (((0.2*$data[17]["cantidad"])/12.5)*(0.9375))*20;
		
		$data[21]["concepto"] = '"Riego de sello a base de Slurry Seal, abase de emulsion asfaltica ecr-mod con aditivos quimicos compatible con agua y agregado arena fina tipo I, como acabado final en ciclovia, incluye: materiales, manodeobray equipoy herramientamenor"';
		$data[21]["precio_unitario"] = 55.23;
		$data[21]["cantidad"] = 1000*($this->options["A"]*$this->options["B"]);
		
		$data[22]["concepto"] = '"Renivelacion de brocales de concreto."';
		$data[22]["precio_unitario"] = 374.84;
		$data[22]["cantidad"] = $this->options["A"]*15;
		
		$data[23]["concepto"] = '"Renivelacion de tapa de registro de 1.00 x 0.65 m, incluye: concreto f c = 150 kg/cm2, agregado maximo de 20 mm."';
		$data[23]["precio_unitario"] = 524.6;
		$data[23]["cantidad"] = $this->options["A"]*20;
		
		$data[24]["concepto"] = '"Renivelacion de coladera de banqueta con brocales de concreto o fierro fundido, incluye: muro de tabique recocido, aplanado con mortero cemento arena 1:3."';
		$data[24]["precio_unitario"] = 313.08;
		$data[24]["cantidad"] = $this->options["A"]*4;
		
		$data[25]["concepto"] = '"Renivelacion de coladera de piso de una rejilla, incluye: muro de tabique recocido y aplanado con mortero cemento-arena 1:3."';
		$data[25]["precio_unitario"] = 269.82;
		$data[25]["cantidad"] = $this->options["A"]*5;
		
		$data[26]["concepto"] = '"Suministro  e  instalacion  de  registro  de  polietileno  de  alta  resistencia,  para  pluvial "';
		$data[26]["precio_unitario"] = 1988.66;
		$data[26]["cantidad"] = $this->options["A"]*1;
		
		$data[27]["concepto"] = '"Suministro y colocacion de marco y rejilla de polietileno alta resistencia boca de tormenta de 66 x 55 cm."';
		$data[27]["precio_unitario"] = 3693.42;
		$data[27]["cantidad"] = $this->options["A"]*2;
		
		$data[28]["concepto"] = '"Suministro e instalacion de marco con tapa de polietileno alta resistencia de 5x 50, para caja de valvula."';
		$data[28]["precio_unitario"] = 2027.44;
		$data[28]["cantidad"] = $this->options["A"]*3;
		
		$data[29]["concepto"] = '"Suministro y colocacion de brocal y tapa de polietileno alta resistencia, para pozo de visita."';
		$data[29]["precio_unitario"] = 2805.9;
		$data[29]["cantidad"] = $this->options["A"]*3;
		
		$data[30]["concepto"] = '"Tubo de PVC tipo sanitario union cementar, extremos lisos de 200 mm de diametro."';
		$data[30]["precio_unitario"] = 215.82;
		$data[30]["cantidad"] = $this->options["A"]*15;
		
		$data[31]["concepto"] = '"Dispositivo DPP-1 Barrera Plastica Vehicular de proteccion vial fabricada en polietileno de media densidad color: naranja, medidas: l: 156 cm, a: 59.5 cm, h: 85 cm, capacidad de llenado: 72 cm3, parausar vacia, con arena a una tercera parte de su capacidad."';
		$data[31]["precio_unitario"] = 3232.01;
		$data[31]["cantidad"] = $this->options["A"]*50;
		
		$data[32]["concepto"] = '"Trafisit, fabricado en polietileno medidas: diametro de base: 50 cm, diametro superior: 43 cm, altura: 107 cm, con 2 cintas reflejantes grado ingenieria sin base"';
		$data[32]["precio_unitario"] = 718.62;
		$data[32]["cantidad"] = $this->options["A"]*50;
		
		$data[33]["concepto"] = '"Pintado de raya de cruce de peatones 40 cm de ancho con pintura coldplastic color blanco con reflejante (microesferas)."';
		$data[33]["precio_unitario"] = 80;
		$data[33]["cantidad"] = (7+$this->options["B"]-2.5)*12;
		
		$data[34]["concepto"] = '"Pintado de raya de alto con pintura coldplastic color blanco en superficies de rodamiento para definir el alto de los vehiculos en los cruces, de 60 cm de ancho. "';
		$data[34]["precio_unitario"] = 120;
		$data[34]["cantidad"] = (7+$this->options["B"]-2.5)*$this->options["F"]*2;
		
		$data[35]["concepto"] = '"Pintado de pictograma area de espera ciclista y motociclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de espera en alto de vialidades, de dimensiones de 3.20 m de altura por 1.80 m de ancho."';
		$data[35]["precio_unitario"] = 2*384.25;
		$data[35]["cantidad"] = 2*$this->options["F"];
		
		$data[36]["concepto"] = '"Pintado de raya sencilla para delimitar arroyo vial con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho "';
		$data[36]["precio_unitario"] = 20;
		$data[36]["cantidad"] = ($this->options["A"]*1000)-(12*$this->options["F"]);
		
		$data[37]["concepto"] = '"Pintado de raya discontinua para delimitar carriles de circulacion con pintura coldplastic color blanco y reflejante (microesferas), en superficies de rodamiento de 10 cm de ancho por 2.5 metros de largo"';
		$data[37]["precio_unitario"] = 20;
		$data[37]["cantidad"] = ($this->options["D"]-1)*(300*$this->options["A"])+(30*$this->options["F"]);
		
		$data[38]["concepto"] = '"Pintado de pictograma carril exclusivo bicicleta, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area de uso exclusivo para bicicletas, de dimensiones de 6.10 m de altura por 1.50 m de ancho."';
		$data[38]["precio_unitario"] = 1968.93;
		$data[38]["cantidad"] = 2*$this->options["F"];
		
		$data[39]["concepto"] = '"Pintado de flecha de sentido (frente y vuelta a la derecha/izquierda) con pintura coldplastic color  blanco y reflejante (microesferas), en superficies de rodamiento para indicar direccion en vialidades con velocidades de 30 km/hora o menores, de dimensiones de flecha de 5.00 m de longitud, 2.70 m de ancho y 0.40 m de base."';
		$data[39]["precio_unitario"] = 430;
		$data[39]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[40]["concepto"] = '"Pintado de pictograma y raya para parada de transporte publico, con pintura pintura colsplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el area deparada de transporte publico, (BUS) de dimensiones de 1.60 m de altura por 1.88 m de ancho. y franjas de 10 cmanchopor 20 mts delong. franjade 60 cmpor 3.20 long."';
		$data[40]["precio_unitario"] = 1377.52;
		$data[40]["cantidad"] = $this->options["F"]/3;
		
		$data[41]["concepto"] = '"Pintado de buffer para apertura de puertezuelas de 10 cm cada una con rayas diagonales, pintura coldplastic color blanco y reflejante (microesferas),  en superficies de rodamiento."';
		$data[41]["precio_unitario"] = 90;
		$data[41]["cantidad"] = ($this->options["A"]*1000)-(24*$this->options["F"]);
		
		$data[42]["concepto"] = '"Pintado de raya doble de 10 cm cada una con pintura coldplastic color blanco y reflejante (microesferas),  en superficies de rodamiento,  para indicar  elemento de confinamiento."';
		$data[42]["precio_unitario"] = 60;
		$data[42]["cantidad"] = ($this->options["A"]*1000)-(24*$this->options["F"]);
		
		$data[43]["concepto"] = '"Pintado de pictograma de control de velocidad, con pintura coldplastic color blanco  y  reflejante (microesferas) en superficies  de rodamiento para  vialidades  con velocidades menores a 100 km/hora, de dimensiones de 4.00 m de altura por 2.00 m de ancho."';
		$data[43]["precio_unitario"] = 700;
		$data[43]["cantidad"] = $this->options["D"]*$this->options["F"];
		
		$data[44]["concepto"] = '"Pintado de raya para cruces ciclistas, con pintura coldplastic color verde y reflejante (microesferas) en superficies de rodamiento para definir el ancho de carril exclusivo ciclista encruces, de 40 cm de ancho."';
		$data[44]["precio_unitario"] = 256.63;
		$data[44]["cantidad"] = 100*$this->options["F"];
		
		$data[45]["concepto"] = '"Pintado de pictograma cruce ciclista, con pintura coldplastic color blanco y reflejante (microesferas) en superficies de rodamiento para indicar el cruce de ciclistas en vialidades, de dimensiones de 2.10 m de altura por 1.18 m de ancho."';
		$data[45]["precio_unitario"] = 322.68;
		$data[45]["cantidad"] = $this->options["F"];
		
		$data[46]["concepto"] = '"Pintado en guarnicion de concreto, con pintura esmalte 100 biosensecolor amarilla y reflejante (microesferas) para indicar el area de espera en alto de vialidades de 15 cm de corona y de 0 a 30 cmde altura."';
		$data[46]["precio_unitario"] = 47.55;
		$data[46]["cantidad"] = 60*$this->options["F"];
		
		$data[47]["concepto"] = '"Senal informativa de servicios via ciclista 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[47]["precio_unitario"] = 1797.23;
		$data[47]["cantidad"] = $this->options["F"];
		
		$data[48]["concepto"] = 'Senal informativa de servicios parada de transporte publico 60 cm por 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultraaltaintensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[48]["precio_unitario"] = 1797.23;
		$data[48]["cantidad"] = $this->options["F"]/3;
		
		$data[49]["concepto"] = '"Senal  informativa de servicios para estacionarse 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor. "';
		$data[49]["precio_unitario"] = 1834.81;
		$data[49]["cantidad"] = 2*$this->options["F"];
		
		$data[50]["concepto"] = '"Senal  restrictiva de velocidad 60 cm de diametro fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclaje de 60 cm. con fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 mdelargoy 3/8 de espesor."';
		$data[50]["precio_unitario"] = 1834.81;
		$data[50]["cantidad"] = $this->options["F"];
		
		$data[51]["concepto"] = '"Senal preventiva de cruce ciclista 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[51]["precio_unitario"] = 1696.17;
		$data[51]["cantidad"] = $this->options["F"];
		
		$data[52]["concepto"] = '"Senal preventiva de motocicletas 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[52]["precio_unitario"] = 1834.81;
		$data[52]["cantidad"] = $this->options["F"];
		
		$data[53]["concepto"] = '"Dispositivo diverso indicador de obstaculo caramelo (DD-5c) de 60 cm x 30 cm  fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y fijacion de poste con barra de acero pulido tipo cold-roll de 0,20 m de largo y 3/8 de espesor, sin poste."';
		$data[53]["precio_unitario"] = 739.63;
		$data[53]["cantidad"] = $this->options["A"]/3;
		
		$data[54]["concepto"] = '"Senal preventiva de apertutra de portezuela 60 cm de lado fabricada en lamina galv. Cal. 16, con pelicula reflejante adhesiva de ultra alta intensidad, con poste tubular de acero galvanizado de 2 de diametro, cal. 14, con altura variable con  tapon de polietileno en la punta. Union de placa y canal de sujecion perfil U de 6x2x1.5 cal. 16 por medio de puncion mecanica. Sistema de fijacion con tornillo de acero galvanizado de cal. 14, tuerca y rondana entre perfil de union (sistema antibandalico) y tubo galvanizado de Ø= 2. Anclajede 60 cm. con fijacion de poste con barra de acero  pulidotipo cold-roll de 0,20 m de largo y 3/8 de espesor."';
		$data[54]["precio_unitario"] = 1696.17;
		$data[54]["cantidad"] = $this->options["F"];
		
		$data[55]["concepto"] = '"Suministro y colocacion de bolardo fabricado en polietileno de una sola pieza con tubo de acero interno, accesorio para delimitar zonas peatonales banquetas, camellones, diseno modernoy anguardistadealtaresistencia, medidas diametro 15 cm., altura 130 cm."';
		$data[55]["precio_unitario"] = 1296.73;
		$data[55]["cantidad"] = 12*$this->options["F"];
		
		$data[56]["concepto"] = '"Semaforo ciclista con carcasa fabricada en policarbonato de alto impacto 2 secciones (R,V) simulan la forma de una bicicleta pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[56]["precio_unitario"] = 4800+52600;
		$data[56]["cantidad"] = $this->options["J"];
		
		$data[57]["concepto"] = '"Semaforo peatonal incandescente de 20 cms, Fabricados en policarbonato, fundidos a presion segun la especificacion de aleacion SC-848 (n.380), Cuerpo fundido en una sola pieza, garantizando mayor resistencia y cierre mas seguro. Sistema de cerrado fabricado con acero inoxidable, Aislamiento total del polvo y la humedad, Cables de calibre 18 AWG con rango de temperatura de hasta 105 ºC, codificados con colores. , Colores permanentes estabilizados con rayos ultravioleta y retardo al fuego, Los focos de 69 Watts tienen una vida de 8000 hrs. De uso. Semaforo con minimo mantenimiento, Nuestras normas de calidad cumplen y sobrepasan las especificaciones ITE."';
		$data[57]["precio_unitario"] = 9600+52600;
		$data[57]["cantidad"] = 4*$this->options["J"];
		
		$data[58]["concepto"] = '"Estacionamiento para bicicleta tipo U invertida a base de tubo redondo de acero galvanizado con diametro de 2, cedula 30 sin costura, con senalamiento de placa de acero de 15 X 20 cm X 1/8 de espesor con senal informativa de doble vista hecha en material reflejante grado ingenieria. Incluye dos anclas de barra de acero pulido tipo cold-roll de 20 cm de largo y 1/2 de diametro. El precio Incluye el equipo y la herramienta necesarios para la correcta ejecucion de los trabajos."';
		$data[58]["precio_unitario"] = 3000;
		$data[58]["cantidad"] = $this->options["K"];
		
		$result = $this->getImporte($data);
		
		$subtotal = 0;
		for($i = 1; $i <= 10; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_preliminares"] = $subtotal;
		
		$subtotal = 0;
		for($i = 11; $i <= 16; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_banquetas_guarniciones"] = $subtotal;
		
		$subtotal = 0;
		for($i = 17; $i <= 21; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_pavimentos"] = $subtotal;
		
		$subtotal = 0;
		for($i = 22; $i <= 30; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_alcantarillado"] = $subtotal;
		
		$subtotal = 0;
		for($i = 31; $i <= 32; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_obra"] = $subtotal;
		
		$subtotal = 0;
		for($i = 33; $i <= 46; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_horizontal"] = $subtotal;
		
		$subtotal = 0;
		for($i = 47; $i <= 54; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_senalizacion_vertical"] = $subtotal;
		
		$subtotal = 0;
		for($i = 55; $i <= 57; $i++) {
			$subtotal += $result[$i]["importe"];
		}
		$result["subtotal_dispositivos_transito"] = $subtotal;
		
		$result["subtotal_mobiliario"] = $result[58]["importe"];
		
		return $result;
	}
	
	public function getImporte($data) {
		$sum = 0;
		foreach($data as $key => $value) {
			$data[$key]["importe"] = $value["cantidad"]*$value["precio_unitario"];
			$sum += $data[$key]["importe"];
		}
		
		$data["subtotal_acumulado"] = $sum;


		$data["iva"] = $data["subtotal_acumulado"]*0.16;
		$data["total"] = $data["subtotal_acumulado"]+$data["iva"];
		
		if(strtoupper($this->options["L"]) == "SI") {
			$data["proyecto_ejecutivo"] = $data["total"]*0.05;
		} else {
			$data["proyecto_ejecutivo"] = 0;
		}
		
		if(strtoupper($this->options["M"]) == "SI") {
			$data["costo_supervision"] = $data["total"]*0.02;
		} else {
			$data["costo_supervision"] = 0;
		}
		
		if(strtoupper($this->options["N"]) == "SI") {
			$data["impuesto_al_millar"] = $data["total"]*0.005;
		} else {
			$data["impuesto_al_millar"] = 0;
		}
		
		
		$data["gran_total"] = $data["total"]+$data["proyecto_ejecutivo"]+$data["costo_supervision"]+$data["impuesto_al_millar"];
		
		return $data;
	}
	
	/*obtener egresos*/
	public function getEgresos($type="estatal") {
		if($type=="estatal") {
			$query = "select * from egresos_estatales where cvegeo=".$this->options["estado"];
			$data  = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			return $data[0];
		} else {
			$query  = "select * from egresos_municipales where cveestado=".$this->options["estado"];
			$query .= " and cvemun=".$this->options["municipio"];
			$data   = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			$data[0]["nomestado"] =  utf8_decode($data[0]["nomestado"]);
			$data[0]["nommun"] =  utf8_decode($data[0]["nommun"]);
			
			return $data[0];
		}
	}
	
	/*obtener ingresos*/
	public function getIngresos($type="estatal") {
		if($type=="estatal") {
			$query = "select * from ingresos_estatales where cvegeo=".$this->options["estado"];
			$data  = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			$data[0][""] = utf8_decode();
			return $data[0];
		} else {
			$query  = "select * from ingresos_municipales where cveestado=".$this->options["estado"];
			$query .= " and cvemun=".$this->options["municipio"];
			$data   = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			$data[0]["nomestado"] =  utf8_decode($data[0]["nomestado"]);
			$data[0]["nommun"] =  utf8_decode($data[0]["nommun"]);
			
			return $data[0];
		}
	}
	
	/*obtener ingresos*/
	public function getIngresosPorcentajes($type=false) {
		if($type=="1000") {
			$query = "select * from ingresos_porcentajes_1000 where cveestado=".$this->options["estado"];
			$data  = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			return $data[0];
		} else {
			$query  = "select * from ingresos_porcentajes where cveestado=".$this->options["estado"];
			$data   = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			return $data[0];
		}
	}
	
	/*obtener egresos*/
	public function getEgresosPorcentajes($type=false) {
		if($type=="1000") {
			$query = "select * from egresos_porcentajes_1000 where cveestado=".$this->options["estado"];
			$data  = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			return $data[0];
		} else {
			$query  = "select * from egresos_porcentajes where cveestado=".$this->options["estado"];
			$data   = $this->Db->query($query);
		
			if(!$data and !is_array($data)) return false;
			
			return $data[0];
		}
	}
	
	public function getCities() {
		$query = "SELECT * from cities";
		$data  = $this->Db->query($query);
		
		if(!$data) return false;
		
		return $data;
	}
	
	/*Modalidades*/
	public function modalidades($id_modalidad = false) {
		$where = "";
		if($id_modalidad != false) {
			$where = " where id_modalidad=".$id_modalidad;
		}
		
		$query = "SELECT * from modalidades" . $where;
		$data  = $this->Db->query($query);
		
		if(!$data) return false;
		
		foreach($data as $key => $value) {
			$query = "SELECT * from proyectos where id_modalidad=".$value["id_modalidad"];
			$proyectos  = $this->Db->query($query);
			$data[$key]["proyectos"] = $proyectos;
		}
		
		
		return $data;
	}
	
	/*Proyectos*/
	public function proyectos($id_modalidad = 0) {
		$query = "SELECT * from proyectos where id_modalidad=".$id_modalidad;
		$data  = $this->Db->query($query);
		
		if(!$data) return false;
		
		return $data;
	}
}
