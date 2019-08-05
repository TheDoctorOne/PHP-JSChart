<html>
    <table style='width:100%;height:100%;'>
        <tr>
            <td style='width:20%'>
                <?php
                $fileList = scandir("/xampp/htdocs/ChartJS/data");
                foreach($fileList as $file) {
                    echo "<span style=\"cursor:pointer;\" onclick=\"changePage('" . $file . "',this)\">";
                    echo $file;
                    echo "</span><br>";
                }
                ?>
            </td>
            <td style='width:80%;height:100%;'>
                <iframe id="chartPage" src="" style="width:80%;height:100%"></iframe>
            </td>
        </tr>
    </table>
    <script>
        var oldMe = null;
        function changePage(msg,me) {
            if(oldMe==null) {
                oldMe=me;
            }
            oldMe.style.color = "black";
            me.style.color = "red";
            oldMe = me;
            document.getElementById("chartPage").outerHTML = "<iframe id='chartPage' src='chart.php?name=" + msg + "' style='width:80%;height:100%'></iframe>";
        }
        </script>
</html>