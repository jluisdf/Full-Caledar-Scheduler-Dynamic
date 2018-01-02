<h3 class="header smaller lighter blue">Calendario Pruebas de Manejo</h3>
<div id='calendar'></div>

<style type="text/css">
#calendar {
	max-width: 90%;
	margin: 3% auto;
}
</style>

<link href='<?php echo base_url('assets/css');?>/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo base_url('assets/css');?>/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<link href='<?php echo base_url('assets/css');?>/scheduler.min.css' rel='stylesheet' />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src='<?php echo base_url('assets/js');?>/moment.min.js'></script>
<script src='<?php echo base_url('assets/js');?>/fullcalendar-1.9.1.min.js'></script>
<script src='<?php echo base_url('assets/js');?>/scheduler.min.js'></script>

<script>
$(function(){
	$('#calendar').fullCalendar({
		schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
		defaultDate: $('#calendar').fullCalendar('today'),
		editable: false,
		aspectRatio: 1.8,
		scrollTime: '08:00',
		slotDuration: '00:30:00', 
		minTime: "08:00:00",
		maxTime: "22:00:00",
		height: 650,
		header: {
			left: 'today prev,next',
			center: 'title'
		},
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		titleFormat: 'D-MMMM-YYYY',
		buttonText:{
			today:    'hoy',
		},
		defaultView: 'timelineDay',
		resourceLabelText: 'Autos diponibles',
		resourceColumns: [
			{
				labelText: 'Modelo',
				field: 'title',
				width: 450
			},
			{
				labelText: 'Vin',
				field: 'vin',
				width: 200
			},
			{
				labelText: 'Vendedor',
				field: 'vendedor',
				width: 250
			}
		],
		refetchResourcesOnNavigate: true,
		resources: function(callback, start, end, timezone) {
			var fecha = (new Date(start)).toISOString().slice(0, 10);
			$.ajax({
	            url: '<?php echo base_url('piso/test_resources')?>',
	            type: 'POST',
	            dataType: 'json',
	            data: {fecha:fecha},
	            success: function(data) {
	                // console.log(data);
	                var resources = [];
	                $.each(data, function (index, value){
						resources.push({
	                        id: data[index].id,
	                        title: data[index].title,
	                        vin: data[index].vin,
	                        vendedor: data[index].vendedor,
	                        eventColor: data[index].eventColor
	                    });
					});
	                callback(resources);
	            }
	        });
		},
	    events: function(start, end, timezone, callback) {
	    	var fecha = (new Date(start)).toISOString().slice(0, 10);
	        $.ajax({
	            url: '<?php echo base_url('piso/test_events')?>',
	            type: 'POST',
	            dataType: 'json',
	            data: {fecha:fecha},
	            success: function(data) {
	            	// console.log(data);
	                var events = [];	                
	                $.each(data, function (index, value){
						events.push({
	                        id: data[index].id,
	                        resourceId: data[index].resourceId,
	                        title: data[index].title,
	                        start: data[index].start,
	                        end: data[index].end
	                    });
					});
	                callback(events);
	            }
	        });
	    }
	});
});//Document Ready
</script>