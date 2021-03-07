<?php

function pjax($class = "data-pjax", $container = "container",$content = "content",$action){

	$pjax = "<script>

		var delay = (function(){
		  var timer = 0;
		  return function(callback, ms){
		    clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		  };
		})();

		pjax.connect({

		'".$container."': '".$content."',";


	if(!empty($class)) $pjax .= "'useClass'  : '".$class."',";

	$pjax .= "
		'beforeSend' : function(){

			".$action["before"]."
		},
		'success': function(event){
			var url = (typeof event.data !== 'undefined') ? event.data.url : '';
			console.log(\"Successfully loaded \"+ url);
			
			".$action["success"]."
		},
		'error': function(event){
			var url = (typeof event.data !== 'undefined') ? event.data.url : '';
			console.log(\"Could not load \"+ url);
	
			".$action["error"]."
		},
		'ready': function(){
			console.log(\"loaded!\");
		}
	});
	</script>
	";

	return $pjax;

}