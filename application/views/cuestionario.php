	<link href="<?php echo base_url(); ?>assets/css/master.css" media="screen" rel="stylesheet" type="text/css">
<div class="m-cuestionario">
	<div class="pure-g">
		<div class="pure-u-1 pure-u-sm-0-24 pure-u-md-3-24 pure-u-lg-5-24"></div>
		<div class="pure-u-1 pure-u-sm-24-24 pure-u-md-18-24 pure-u-lg-14-24">
			<div class="m-cuestionario__body">
				<form name="cuestionario" id="cuestionario" action="<?php echo base_url() . "calificar";?>" method="POST" >
					<input type="hidden" name="modalidad" value="<?php echo $idModalidad;?>">
					<div id="slickQuiz">
						<h1 class="quizName"></h1>
						<div class="quizArea">
							<div class="quizHeader">
								<div class="align-center">
									<a class="pure-button bg-purple3 color-white startQuiz js-start-quiz" href="#">Comenzar</a>
								</div>
								
							</div>
							<div class="align-center">
								<h1 class='m-cuestionario-timer js-timer'></h1>
							</div>
						</div>

						<div class="quizResults">
							<h3 class="quizScore">Tu puntuación: <span></span></h3>

							<h3 class="quizLevel"><strong>Ranking:</strong> <span></span></h3>

							<div class="quizResultsCopy"></div>
							<h3 class="quizScoreX">
								<span class="quizScoreX-number"></span>% de tus respuestas correctas<span id="quizScoreX-less"></span>
							</h3>
							
							<div id="preguntas"></div>
						</div> 
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/slickQuiz.js"></script>
<script>
	var quizJSON = {
		"info": {
			"name":    "<?php echo $modalidad;?> ",
			"main":    "Estás por presentar la evaluación de la modalidad <?php echo $modalidad;?>, ¿estás listo para hacerlo? Si tu respuesta es sí, haz click en 'Comenzar'. El test consta de 10 preguntas, tienes 10 minutos para terminarlo y la nota mínima para aprobar es 8.",
			"results": "Has concluido el cuestionario."
		},
		"questions": [
			<?php foreach($preguntas as $key => $pregunta) { ?>
			{
			"q": "<?php echo $pregunta['pregunta'];?>",
			"a": [
				<?php $textpreguntas = "";?><?php foreach($respuestas as $respuesta) { ?><?php if($pregunta['id_pregunta'] == $respuesta['id_pregunta']) { ?>
				<?php $textpreguntas .= '{"option": "'.$respuesta['respuesta'].'", "value":"'.$respuesta['id_respuesta'].'", "correct": true, idQuestion:'.$respuesta['id_pregunta'].'},';?>
				<?php } ?><?php } ?><?php echo trim($textpreguntas, ",");?>
			]
			}<?php if($key < count($preguntas)) echo ","; ?>
			<?php } ?>
		]
	};
</script>
<script>
	var pluginExtra = false;
	var counting = null;
	
	function sendForm() {
		clearTimeout(counting);
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url().'calificar'; ?>",
			data : $("#cuestionario").serialize(),
			success: function(data) {
				$(".quizScoreX-number").html(data.calificacion);
				
				if (data.calificacion <=60) {
					$('#quizScoreX-less').text(' ¡Tu ciudad necesita más de ti, no te rindas!');
				}
				if (data.calificacion >=61 && data.calificacion <79) {
					$('#quizScoreX-less').text(' ¡Estás a punto de transformar tu ciudad!');
				}
				if (data.calificacion >=80) {
					$('#quizScoreX-less').text(' ¡Contigo, tu ciudad se transformará!');
				}
				// if(data.calificacion >= 60) {
				// 	$("#quizConstancia").show();
				// } else {
				// 	$("#quizScoreX-less").show();
				// }
			}
		});
	}
	
	$(function () {
		var c = 600;
		
		$('#slickQuiz').slickQuiz();
		
		$('.js-start-quiz').on('click', function(e){
			e.preventDefault();
			timedCount();
		});

		function timedCount() {
			var hours = parseInt( c / 3600 ) % 24;
			var minutes = parseInt( c / 60 ) % 60;
			var seconds = c % 60;
			var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
			c = c - 1;
			$('.js-timer').html(result);
			if(c !== -1 ){
				counting = setTimeout(function(){ 
					timedCount();
				}, 1000);
			}
			else {
				clearTimeout(counting);
				sendForm();
				$('ol.questions').remove();
				pluginExtra.method.completeQuiz();
			}
		}

	});
</script>

