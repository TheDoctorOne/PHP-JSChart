<html>
    <script src="Chart.min.js"></script>
    <style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
    <body>
        <?php
        if( isset($_GET['name']) ) {
            //Get file name
            $PATH = "/xampp/htdocs/ChartJS";
            $FILENAME = "/data/" . $_GET['name'];
            $FILE = $PATH . $FILENAME;
            //File Operations
            $fp = fopen($FILE, "r");
            if( $fp == false ) {
                echo "Error: File Opening";
                exit();
            }
            $content = "";
            while(!feof($fp)) {
                $content = $content . fgets($fp);
            }
            //print_r(explode("\n",$content));
            //explode("\n",$content)    in to lines
            //explode(",",$content)     in to values
            $X_AXIS_NUMBERS = "";
            $x = 0;
            $ACC_X = "";
            $ACC_Y = "";
            $ACC_Z = "";
            $GYRO_X = "";
            $GYRO_Y = "";
            $GYRO_Z = "";
            $EULER_X = "";
            $EULER_Y = "";
            $EULER_Z = "";
            foreach(explode("\n", $content) as $line) { //line
                $lineExplode = explode(",", $line);
                if(isset($lineExplode[0]) && isset($lineExplode[1]) && isset($lineExplode[2]) && isset($lineExplode[3]) && isset($lineExplode[4]) && isset($lineExplode[5]) && isset($lineExplode[6]) && isset($lineExplode[7]) && isset($lineExplode[8])) {
                    $ACC_X = $ACC_X . $lineExplode[0] . ",";
                    $ACC_Y = $ACC_Y . $lineExplode[1] . ",";
                    $ACC_Z = $ACC_Z . $lineExplode[2] . ",";
                    $GYRO_X = $GYRO_X . $lineExplode[3] . ",";
                    $GYRO_Y = $GYRO_Y . $lineExplode[4] . ",";
                    $GYRO_Z = $GYRO_Z . $lineExplode[5] . ",";
                    $EULER_X = $EULER_X . $lineExplode[6] . ",";
                    $EULER_Y = $EULER_Y . $lineExplode[7] . ",";
                    $EULER_Z = $EULER_Z . $lineExplode[8] . ",";

                $X_AXIS_NUMBERS = $X_AXIS_NUMBERS . $x . ",";
                $x = $x + 1;
                }
            }
            //Deleting last comma from strings
            rtrim($ACC_X , ",");
            rtrim($ACC_Y , ",");
            rtrim($ACC_Z , ",");
            rtrim($GYRO_X , ",");
            rtrim($GYRO_Y , ",");
            rtrim($GYRO_Z , ",");
            rtrim($EULER_X , ",");
            rtrim($EULER_Y , ",");
            rtrim($EULER_Z , ",");
            rtrim($X_AXIS_NUMBERS);
            
        } else {
            echo "Do Not Open This File by Hand.";
        }
        ?> 
        <h3><?php echo $_GET['name']; ?></h3>
        <button id="ACC_BUT">ACC</button>
        <button id="GYRO_BUT">GYRO</button>
        <button id="EULER_BUT">EULER</button>
        <div style="width:100%;">
            <canvas id="canvas"></canvas>
        </div>
        
    </body>
    <script>
        var ACC = {
			labels: [<?php echo $X_AXIS_NUMBERS; ?>],
			datasets: [{
				label: 'X',
				borderColor: "red",
				backgroundColor: "red",
				fill: false,
				data: [
                    <?php 
                    echo $ACC_X;
                    ?>
				],
				yAxisID: 'y-axis-1',
			}, {
				label: 'Y',
				borderColor: "blue",
				backgroundColor: "blue",
				fill: false,
                data: [
                    <?php 
                    echo $ACC_Y;
                    ?>
				],
				yAxisID: 'y-axis-2'
			}, {
				label: 'Z',
				borderColor: "green",
				backgroundColor: "green",
				fill: false,
				data: [
                    <?php 
                    echo $ACC_Z;
                    ?>
				],
				yAxisID: 'y-axis-3'
			}]
		};
        var GYRO = {
			labels: [<?php echo $X_AXIS_NUMBERS; ?>],
			datasets: [{
				label: 'X',
				borderColor: "red",
				backgroundColor: "red",
				fill: false,
				data: [
                    <?php 
                    echo $GYRO_X;
                    ?>
				],
				yAxisID: 'y-axis-1',
			}, {
				label: 'Y',
				borderColor: "blue",
				backgroundColor: "blue",
				fill: false,
                data: [
                    <?php 
                    echo $GYRO_Y;
                    ?>
				],
				yAxisID: 'y-axis-2'
			}, {
				label: 'Z',
				borderColor: "green",
				backgroundColor: "green",
				fill: false,
				data: [
                    <?php 
                    echo $GYRO_Z;
                    ?>
				],
				yAxisID: 'y-axis-3'
			}]
		};
        var EULER = {
			labels: [<?php echo $X_AXIS_NUMBERS; ?>],
			datasets: [{
				label: 'X',
				borderColor: "red",
				backgroundColor: "red",
				fill: false,
				data: [
                    <?php 
                    echo $EULER_X;
                    ?>
				],
				yAxisID: 'y-axis-1',
			}, {
				label: 'Y',
				borderColor: "blue",
				backgroundColor: "blue",
				fill: false,
                data: [
                    <?php 
                    echo $EULER_Y;
                    ?>
				],
				yAxisID: 'y-axis-2'
			}, {
				label: 'Z',
				borderColor: "green",
				backgroundColor: "green",
				fill: false,
				data: [
                    <?php 
                    echo $EULER_Z;
                    ?>
				],
				yAxisID: 'y-axis-3'
			}]
		};
        
        function loadGraph(chartData, chartTitle) {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = Chart.Line(ctx, {
				data: chartData,
				options: {
					responsive: true,
					hoverMode: 'index',
					stacked: false,
					title: {
						display: true,
						text: chartTitle
					},
					scales: {
						yAxes: [{
							type: 'linear',
							display: true,
							position: 'left',
							id: 'y-axis-1',
						}, {
							type: 'linear', 
							display: true,
							position: 'right',
							id: 'y-axis-2',
						}, {
							type: 'linear', 
							display: true,
							position: 'right',
							id: 'y-axis-3',
						}],
					}
				}
			});
		};
		document.getElementById('ACC_BUT').addEventListener('click', function() {
            loadGraph(ACC,"ACC");

			window.myLine.update();
		});
        document.getElementById('GYRO_BUT').addEventListener('click', function() {
			selected = GYRO;
            loadGraph(GYRO,"GYRO");

			window.myLine.update();
		});
        document.getElementById('EULER_BUT').addEventListener('click', function() {
			selected = EULER;
            loadGraph(EULER,"EULER");

			window.myLine.update();
		});
    </script>
</html>