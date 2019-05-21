$(document).ready(function(){
	var getYear = $("#getYear").val();//amek dari input hidden
	var staffid = $("#staffid").val();
	$.ajax({
		url : "http://localhost/gdashboard/linegraph.php",
		type : "GET",
		data: { staffid: staffid, getYear: getYear },//parameter
		success : function(data){
			//console.log(data);

			var monthname = [];
			var sumleave = [];
			
			for(var i in data) {
				monthname.push(data[i].monthname);
				sumleave.push(data[i].sumleave);
			}
			
			var chartdata = {
				labels: monthname,
				datasets: [
					{
						label: "Total Leave",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: sumleave
					},
					
				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {

		}
	});
});