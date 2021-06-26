<?php
        require "models/user.php";
        require "models/product.php";
        require "models/protype.php";
        require "models/manufacture.php";
        require "models/page.php"; 
        require "models/orders.php";
        $order = new Order();
        $ordercount = $order->CountOrder();
        $soluong = $ordercount['total'];
        $product = new Product();
        $protype = new Protype();
        $manufacture = new Manufacture();       
        if(isset($_GET['manu_id']))
        {
            $manu_id = $_GET['manu_id'];
            $manuarr = $manufacture->getAllFactureNameById($manu_id);
            $manu_name = $manuarr['manu_name'];            
        } 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mobile Admin</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="css/uniform.css" />
    <link rel="stylesheet" href="css/select2.css" />
    <link rel="stylesheet" href="css/matrix-style.css" />
    <link rel="stylesheet" href="css/matrix-media.css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        ul.pagination {
            list-style: none;
            float: right;
        }

        ul.pagination li.active {
            font-weight: bold
        }

        ul.pagination li {
            float: left;
            display: inline-block;
            padding: 10px
        }
    </style>
</head>

<body>
   
    <!--Header-part-->
    <div id="header">
        <h1><a href="http://localhost:8082/mobile/"><img src="images/logo.png" alt=""></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown"
                    data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i> <span
                        class="text">Welcome Super Admin</span><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
                    <li class="divider"></li>
                    <li><a href="../logout.php"><i class="icon-key"></i> Log Out</a></li>
                </ul>
            </li>
            <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages"
                    class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span
                        class="label label-important"><?php echo $soluong ?></span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
                    <li class="divider"></li>
                    <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
                </ul>
            </li>
            <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
            <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span
                        class="text">Logout</span></a></li>
        </ul>
    </div>
    <!--start-top-serch-->
    <div id="search">
        <form action="result.php" method="get">
            <input name="key" type="text" placeholder="Search here..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-th"></i>Tables</a>
        <ul>
            <li><a href="index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
            <li> <a href="manufactures.php"><i class="icon icon-th-list"></i> <span>Manufactures</span></a></li>
            <li> <a href="protypes.php"><i class="icon icon-th-list"></i> <span>Product type</span></a></li>
            <li> <a href="users.php"><i class="icon icon-th-list"></i> <span>Users</span></a></li>

        </ul>
    </div><!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i>
                    Home</a></div>
            <h1>Edit ManuFacture</h1>
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Manufacture info</h5>
                        </div>
                        <div class="widget-content nopadding">

                            <!-- BEGIN USER FORM -->
                            <form action="check/check_edit.php" method="post" class="form-horizontal"
                                enctype="multipart/form-data">
                                <div class="control-group">
                                    <label class="control-label">Manu Name :</label>
                                    <div class="controls">
                                        <input type="text" class="span11" placeholder="ManuName" name="manu_name" value="<?php echo $manu_name ?>" required /> *
                                    </div>
                                </div>                                                            
                                <div class="form-actions">
                                    <input type="hidden" name="manu_id" value="<?php echo $manu_id ?>">
                                    <input type="hidden" name="action" value="manu">
                                    <button type="submit" class="btn btn-success">Edit</button>
                                </div>
                        </div>
                            </form>
                            <!-- END USER FORM -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <!--Footer-part-->
    <div class="row-fluid">
        <div id="footer" class="span12"> 2021 &copy; TDC - Lập trình web 1</div>
    </div>
    <!--end-Footer-part-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.ui.custom.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.uniform.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/matrix.js"></script>
    <script src="js/matrix.tables.js"></script>
</body>

</html>