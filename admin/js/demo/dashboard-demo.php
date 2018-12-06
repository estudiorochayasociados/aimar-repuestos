
<script>
	Analisis function(a, b, c) {
		var a = "50"
		var b = "20"
		var c = "30"
		
		Morris.Donut({
			element : 'morris-area-chart',
			data : [{
				label : "Inscriptos Nuevos",
				value : a
			}, {
				label : "Socios Inscriptos Nuevos",
				value : b
			}, {
				label : "Mail-Order Sales",
				value : c
			}],
			resize : true
		});

	}; 
</script>