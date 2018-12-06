/*$(function() {
	Morris.Donut({
		element : 'morris-area-chart',
		data : [{
			label : "Inscriptos Nuevos",
			value : 52
		}, {
			label : "Socios Inscriptos Nuevos",
			value : 30
		}, {
			label : "Mail-Order Sales",
			value : 20
		}],
		resize : true
	});

});
*/

function Analisis(a,b,c)  {
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
}
