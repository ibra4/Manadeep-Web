
   $(document).ready( function () {
	   var datax = '{"past":[0,0,0,2000,0,0,0,1000,0,0,0,0],"this":[8970,0,0,0,0,0,0,0,0,0,0,0],"next":[0,0,0,0,0,0,0,0,0,0,0,0]}';
	   var data = JSON.parse(datax);
	   
	   var ctxL = document.getElementById("lineChart").getContext('2d');
	   var myLineChart = new Chart(ctxL, {
	   type: 'line',
	   data: {
	   labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	   datasets: [{
	   label: "Users",
	   data: data.past,
	   backgroundColor: [
	   'rgba(105, 0, 132, .2)',
	   ],
	   borderColor: [
	   'rgba(200, 99, 132, .7)',
	   ],
	   borderWidth: 2
	   },
	   {
	   label: "Drivers",
	   data: data.this,
	   backgroundColor: [
	   'rgba(0, 137, 132, .2)',
	   ],
	   borderColor: [
	   'rgba(0, 10, 130, .7)',
	   ],
	   borderWidth: 2
	   },
	   {
	   label: "Orders",
	   data: data.next,
	   backgroundColor: [
	   'rgba(66, 245, 158, .2)',
	   ],
	   borderColor: [
	   'rgba(66, 245, 66, .7)',
	   ],
	   borderWidth: 2
	   }
	   ]
	   },
	   options: {
	   responsive: true
	   }
	   });

    } );