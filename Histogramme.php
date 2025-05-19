<div class="Histo_circ">
    <canvas id="histogramme" width="400" height="400"></canvas>
</div>

<script>
    var recettes = <?php echo json_encode(array_values($recettes)); ?>;
    var mois = <?php
        // Affichage des mois avec première lettre en majuscule et en français
        setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
        echo json_encode(array_map(function($m) {
            return ucfirst(strftime('%B', strtotime("01 $m")));
        }, array_keys($recettes)));
    ?>;

    var ctx = document.getElementById('histogramme').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: mois,
            datasets: [{
                label: 'Recettes mensuelles',
                data: recettes,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '50%', // Remplace cutoutPercentage (deprecated) pour Chart.js v3+
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Histogramme des recettes mensuelles'
                }
            }
        }
    });
</script>
