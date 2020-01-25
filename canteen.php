<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Подключаем css -->
     <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Моя столовая</title>
</head>
      
<body style="background-color:#f0f0f0">

    <?php
    header('Content-Type: text/html; charset=utf-8');
    //подключение к базе данных
    $connection = mysqli_connect('127.0.0.1', 'root' , '' , 'canteen');
    
    if($connection == false)
    {
        echo 'Не удалось подключиться к базе данных<br>';
        echo mysqli_connect_error();
        exit();
    }
    mysqli_query($connection,"SET NAMES UTF8");
    
    date_default_timezone_set('Europe/Minsk');
    
    ?>
    
    <!-- js время с обновлением каждые 30 сек -->
    <div class="container-fluid">
        <h5>
    <p id="ourDate"></p>
    <script type="text/javascript">
        var now,month;
        function dateSet()
        {
            now = new Date();
            month = new Array(12);
            month[0]="января";
            month[1]="февраля";
            month[2]="марта";
            month[3]="апреля";
            month[4]="мая";
            month[5]="июня";
            month[6]="июля";
            month[7]="августа";
            month[8]="сентября";
            month[9]="октября";
            month[10]="ноября";
            month[11]="декабря";
            writeDate();
        }
        
        function checkTime(time)
        {
            if (time<10)
            {
                time="0" + time;
            }
            return time;
        }
        function writeDate()
        {
            document.getElementById("ourDate").innerHTML = "Сегодня " + now.getDate() + " " + month[now.getMonth()] + ", " + checkTime(now.getHours()) + ":" + checkTime(now.getMinutes());
            setTimeout(dateSet,1000*30);    
            //console.log(now.getMonth());
        }
        
        dateSet();  
    </script>
        </h5> 
 </div>
    
    <?php
    //функция с выводом таблицы
    function printTable($meal)
     {
            $time = "";
        if($meal == "breakfast")
        {
            $time = "br";      
        }
        elseif($meal == "dinner")
        {
            $time = "di";
        }
        else
        {
            $time = "lu";
        } 
        
    $connection = mysqli_connect('127.0.0.1', 'root' , '' , 'canteen');
        mysqli_query($connection,"SET NAMES UTF8");
        $selectsql = mysqli_query($connection, "SELECT * FROM ".$meal ); 
     echo "<table class='table table-striped col-xs-12 col-sm-11 col-md-10 col-lg-7'>";
        
     echo "<thead>" . 
         "<tr class='table-active'>" . 
         "<th> </th>" . 
         "<th>Наименование</th>" . 
         "<th>Цена</th>" . 
         "<th>Состав</th>" . 
         "<th>Ккал</th>" .  
         "</tr>" . 
         "</thead>";
        
     while ($record = (mysqli_fetch_assoc($selectsql)) )
     {  
         echo 
             "<tr>" . 
             '<td><img class="foodImage" src="data:image/jpeg;base64,'.base64_encode( $record['image_'.$time] ).'"/></td>' .
             "<td>" . $record['name_'.$time] ."</td>" . 
             "<td>" . $record['cost_'.$time] ." руб." . "</td>" .
             "<td>" . $record['structure_'.$time] . "</td>" . 
             "<td>" . $record['ckal_'.$time] . " ckal" . "</td>" .
             "</tr>";
     }
         echo "</table>";
     }
    ?>

      
    <!-- Кнопки: завтрак обед и ужин -->
    <div class="btn-group btn-group-lg" style="width:60%">
           
        <form class="btn-group" method="post" style="width:20%; min-width:150px";>
        <input class="btn btn-secondary" type="submit" name="breakfast" value="Завтрак";/>
        </form>

        <form class=" btn-group" method="post" style="width:20%; min-width:150px";>
        <input class="btn btn-secondary" type="submit" name="dinner" value="Обед";/>
        </form>

         <form class=" btn-group" method="post" style="width:20%; min-width:150px"; >
        <input class="btn btn-secondary " type="submit" name="lunch" value="Ужин";/>
        </form>
        
   </div>  
   
        
    <div class="container-fluid">
        
    <?php
    // вывод таблицы и строки в зависимости от времени
    $time = date("G");

    if ($time >=8 and $time <= 12 and (!isset($_POST['breakfast'])) and (!isset($_POST['dinner'])) and (!isset($_POST['lunch'])))
    {
        echo "<h5>" . "Сегодня на завтрак: " . "</h5>";
        printTable('breakfast');
    }
    
    elseif ($time >=13 and $time <= 17 and (!isset($_POST['dinner']))  and (!isset($_POST['lunch'])) and (!isset($_POST['breakfast'])))
    {
        echo "<h5>" . "Сегодня на обед: " . "</h5>";
        printTable('dinner');
    }
    
    elseif ($time >=18 and $time <= 21 and (!isset($_POST['lunch'])) and (!isset($_POST['dinner'])) and (!isset($_POST['breakfast'])))
    {
        echo "<h5>" . "Сегодня на ужин: " . "</h5>";
        printTable('lunch');
    }
        
    else if(isset($_POST['breakfast'])) 
    {
        printTable('breakfast'); 
    }
        
    else if(isset($_POST['dinner'])) 
    {
        printTable('dinner');
    }
        
    else if(isset($_POST['lunch'])) 
    {
        printTable('lunch');
    }
        
    else
    {
        echo "Столовая, к сожалению, закрыта.";   
    }
        
 ?> 
    </div>
    
     <!-- Подключаем jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <!-- Подключаем плагин Popper (необходим для работы компонента Dropdown и др.) -->
    <script src="bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Подключаем Bootstrap JS --> 
    <script src="bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    </body>
      

</html> 





