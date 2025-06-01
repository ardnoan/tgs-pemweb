 <div class="footer">
   <p>Ardi Nurohman - <?php echo Date("Y"); ?></p>
 </div>
 <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js">
 </script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
 </script>
 <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
 <script>
   $(document).ready(function() {
     $('#myTable').DataTable();
   });
 </script>
 <script>
   $(document).ready(function() {
     $('#myTable').DataTable();
     // Accordion functionality
     $('.accordion-button').click(function() {
       $(this).next('.collapse').collapse('toggle');
     });
   });
   // Load the Chart after the DOM is fully loaded
   document.addEventListener("DOMContentLoaded", function() {
     const ctx = document.getElementById('recordChart').getContext('2d');
     const colors = [
       'rgba(255, 99, 132, 0.2)',
       'rgba(54, 162, 235, 0.2)',
       'rgba(255, 206, 86, 0.2)',
       'rgba(75, 192, 192, 0.2)',
       'rgba(153, 102, 255, 0.2)'
     ];
     const borderColors = [
       'rgba(255, 99, 132, 1)',
       'rgba(54, 162, 235, 1)',
       'rgba(255, 206, 86, 1)',
       'rgba(75, 192, 192, 1)',
       'rgba(153, 102, 255, 1)'
     ];
     const recordChart = new Chart(ctx, {
       type: 'bar',
       data: {
         labels: <?php echo json_encode(array_keys($data)); ?>,
         datasets: [{
           label: 'Jumlah Record',
           data: <?php echo json_encode(array_values($data)); ?>,
           backgroundColor: colors,
           borderColor: borderColors,
           borderWidth: 1
         }]
       },
       options: {
         scales: {
           y: {
             beginAtZero: true
           }
         }
       }
     });
   });
 </script>
 </body>

 </html>