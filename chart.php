<html>
    <script src="dygraph.js"></script> 
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
                    if ($lineExplode[0] > -1000 && $lineExplode[0] < 1000 && $lineExplode[1] > -1000 && $lineExplode[1] < 1000 && $lineExplode[2] > -1000 && $lineExplode[2] < 1000 &&
                    $lineExplode[3] > -1000 && $lineExplode[3] < 1000 && $lineExplode[4] > -1000 && $lineExplode[4] < 1000 && $lineExplode[5] > -1000 && $lineExplode[5] < 1000 &&
                    $lineExplode[6] > -100 && $lineExplode[6] < 100 && $lineExplode[7] > -100 && $lineExplode[7] < 100 && $lineExplode[8] > -100 && $lineExplode[8] < 100) {
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
        <button id="ZOOM-OUT" style="float:right;">ZOOM CLEAR</button>
        <div id="graphdiv" style="width:100%;height"></div>
        
    </body>
    <script>
        function translateGraphToACC() {
            g = new Dygraph(
            // containing div
            document.getElementById("graphdiv"),
            <?php 
            $ACC_X_EXPLODE = explode(",",$ACC_X);
            $ACC_Y_EXPLODE = explode(",",$ACC_Y);
            $ACC_Z_EXPLODE = explode(",",$ACC_Z);
            echo "\"ACC,X,Y,Z\\n\" + \n";
            for($i=0; $i < $x ; $i = $i + 1) {
                echo "\"" . $i . "," . $ACC_X_EXPLODE[$i] . "," . $ACC_Y_EXPLODE[$i] . "," . $ACC_Z_EXPLODE[$i];
                echo "\\n" . "\"" . "+" . "\n";
            }
            echo "\"\"";
            ?>

            );
        }
        function translateGraphToGYRO() {
            g = new Dygraph(
            // containing div
            document.getElementById("graphdiv"),
            <?php 
            $ACC_X_EXPLODE = explode(",",$GYRO_X);
            $ACC_Y_EXPLODE = explode(",",$GYRO_Y);
            $ACC_Z_EXPLODE = explode(",",$GYRO_Z);
            echo "\"ACC,X,Y,Z\\n\" + \n";
            for($i=0; $i < $x ; $i = $i + 1) {
                echo "\"" . $i . "," . $ACC_X_EXPLODE[$i] . "," . $ACC_Y_EXPLODE[$i] . "," . $ACC_Z_EXPLODE[$i];
                echo "\\n" . "\"" . "+" . "\n";
            }
            echo "\"\"";
            ?>

            );
        }
        function translateGraphToEULER() {
            g = new Dygraph(
            // containing div
            document.getElementById("graphdiv"),
            <?php 
            $ACC_X_EXPLODE = explode(",",$EULER_X);
            $ACC_Y_EXPLODE = explode(",",$EULER_Y);
            $ACC_Z_EXPLODE = explode(",",$EULER_Z);
            echo "\"ACC,X,Y,Z\\n\" + \n";
            for($i=0; $i < $x ; $i = $i + 1) {
                echo "\"" . $i . "," . $ACC_X_EXPLODE[$i] . "," . $ACC_Y_EXPLODE[$i] . "," . $ACC_Z_EXPLODE[$i];
                echo "\\n" . "\"" . "+" . "\n";
            }
            echo "\"\"";
            ?>

            );
        }
        translateGraphToACC();
        var last = "ACC";

		document.getElementById('ACC_BUT').addEventListener('click', function() {
            document.getElementById('graphdiv').outerHTML = "<div id=\"graphdiv\" style=\"width:100%;height\"></div>";
            last = "ACC";
            translateGraphToACC();
		});
        document.getElementById('GYRO_BUT').addEventListener('click', function() {
            document.getElementById('graphdiv').outerHTML = "<div id=\"graphdiv\" style=\"width:100%;height\"></div>";
            last = "GYRO";
            translateGraphToGYRO();
		});
        document.getElementById('EULER_BUT').addEventListener('click', function() {
            document.getElementById('graphdiv').outerHTML = "<div id=\"graphdiv\" style=\"width:100%;height\"></div>";
            last = "EULER";
            translateGraphToEULER();
		});
        document.getElementById('ZOOM-OUT').addEventListener('click', function() {
            document.getElementById('graphdiv').outerHTML = "<div id=\"graphdiv\" style=\"width:100%;height\"></div>";
            if(last == "ACC") {
                translateGraphToACC();
            } else if(last == "GYRO") {
                translateGraphToGYRO();
            } else if(last == "EULER") {
                translateGraphToEULER();
            }
		});
    </script>
</html>