<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Staff Area</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

   
    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <link href="styleStaff.css" rel="stylesheet" type="text/css">

    <!-- jquery ui-->
    <link href="../vendor/jqueryUi/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" src="../vendor/jqueryUI/js/jquery.js"></script>

    


   

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- some plugin-->

    <style>
         #zartan_assessment_error_messages {
                background: white;
                color:red;
                min-height: 30px;
               
                margin: 5px auto;
                padding: 5px;
                border: 1px solid red;
                border-radius: 5px;
               
        }

        #zartan_error_message{
             background: white;
            color:red;
            min-height: 30px;
           
            margin: 5px auto;
            padding: 5px;
            border: 1px solid ;
            border-radius: 5px;
            text-align: justify;
        }

        #zartan_login_error_message{
            background: white;
            color:red;
            min-height: 30px;
           
            margin: 5px auto;
            padding: 5px;
            border: 1px solid ;
            border-radius: 5px;
            text-align: justify;
        }

        #make_decision a{
          text-decoration: none;   
        }

        table, th, td {
            font-size: 14px;
             font-family:Georgia;
        }

        th {
            background-color: #4CAF50;
            color: white;

        }

        #success_update {
            color:white;margin-left:15px;
            background:#109E20;
            padding:7px;
            border-radius:5px;
            margin-top:15px;
            font-weight:bold;
        }

        #without_evidance th {
            background: #985671;
        }

         body {
           background: white;
        }



    </style>



<script>
          $( function() {
         $( "#datepicker" ).datepicker({ minDate: +0});
       
          $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
      } );

            $( function() {
         $( "#datepicker2" ).datepicker({ minDate: +0});
       
          $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );   
      } );

       
</script>
  

</head>