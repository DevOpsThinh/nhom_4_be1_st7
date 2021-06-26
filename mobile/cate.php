<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mobile Shopping</title>
    <link rel="icon" href="./images/logo.png" type="image/icon type">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->
<?php
    require "models/db.php";
    require "models/product.php";
    require "models/protype.php";
    require "models/manufacture.php";
    require "models/page.php";
    $product = new Product();
    $manufacture = new Manufacture();
    $protype = new Protype();
?>
<body>        
    <div class="header-bottom">
        <!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span
                                class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                        </button>
                        <div class="logo"> <a href="index.html"><img src="images/logo.png" alt="" /></a> </div>
                    </div>
                    <div class="mainmenu pull-right">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li class="dropdown"><a href="cate.php">Products<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <?php                                      
                                        $prodarr = $protype->getAllProtype();
                                        foreach ($prodarr as $key) {  
                                            if(isset($_GET['manu_id']))
                                            {
                                                $manu_id = $_GET['manu_id'];
                                        ?>
                                            <li><a href="cate.php?manu_id=<?php echo $manu_id ?>&type_id=<?php echo $key['type_id'] ?>"><?php echo $key['type_name'] ?></a><li>
                                     <?php } 
                                            else {                                               
                                    ?>
                                            <li><a href="cate.php?type_id=<?php echo $key['type_id'] ?>"><?php echo $key['type_name'] ?></a><li>
                                <?php } } ?>                             
                                </ul>
                            </li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="cart.php">Cart</a></li>
                        </ul>
                        <div class="search_box pull-right">
                            <form action="result.php" method="get">
                                <input type="text" placeholder="Search" name="key"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
    </header>
    <!--/header-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Category</h2>
                        <div class="panel-group category-products" id="accordian">
                            <?php     
                                $manuarr = $manufacture->getAllFactureName();                                      
                                foreach($manuarr as $namefac)
                                {
                                    if(isset($_GET['type_id']))
                                    {
                                        $type_id = $_GET['type_id'];
                                ?>
                                    <!--category-productsr-->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a href="cate.php?manu_id=<?php echo $namefac['manu_id']?>&type_id=<?php echo $type_id ?>"><?php echo $namefac['manu_name']?></a></h4>
                                        </div>
                                    </div>
                               <?php } 
                                    else {
                               ?>
                                   <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a href="cate.php?manu_id=<?php echo $namefac['manu_id']?>"><?php echo $namefac['manu_name']?></a></h4>
                                            </div>
                                        </div>
                          <?php } } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <!--features_items-->
                        <h2 class="title text-center">
                            <?php                                                                                                     
                                if(isset($_GET['type_id']))
                                {             
                                    //xuat ten loai theo id
                                    $type_id = $_GET['type_id'];
                                    $prodarr = $protype->getProtypeName($type_id);
                                    foreach($prodarr as $key)
                                    {                                        
                                            echo $key['type_name'];
                                            break;                                                                            
                                    }
                                } 
                                elseif (isset($_GET['manu_id'])) {
                                    $manu_id = $_GET['manu_id'];                                    
                                    foreach ($manuarr as $key) {
                                        if($key['manu_id'] == $manu_id)
                                        {
                                            echo $key['manu_name'];
                                        }
                                    }
                                }
                                else {
                                    echo "Features Items";
                                }
                            ?>
                        </h2>
                        <?php                                                            
                            $prod = $product->getAllProTypeProducts();                      
                            if(isset($_GET['type_id']) && isset($_GET['manu_id']))
                            {
                                $type_id = $_GET['type_id'];
                                $manu_id = $_GET['manu_id'];
                                //xuat san pham theo ten loai                                   
                                foreach ($prod as $key) {
                                    if($key['type_id'] == $type_id && $key['manu_id'] == $manu_id)
                                    {
                                ?>
                            <div class="col-sm-4">                             
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="admin/images/<?php echo $key['pro_image'] ?>" alt="" width = "300" height="300" />
                                            <h2><?php echo number_format($key['price'],0) . "₫" ?></h2>
                                            <p><?php echo $key['name'] ?></p>
                                            <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                        <div class="product-overlay">
                                            <div class="overlay-content">
                                            <h2><?php echo number_format($key['price'],0) . "₫" ?></h2>
                                            <p><a href="detail.php?id=<?php echo $key['id'] ?>"><?php echo $key['name'] ?></a></p>
                                            <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                          
                            </div>
                   <?php } } }
                   elseif (isset($_GET['manu_id'])) {
                        $manu_id = $_GET['manu_id'];
                    //xuat san pham theo ten hang
                       foreach ($prod as $key) {
                           if($key['manu_id'] == $manu_id)
                           {  
                    ?>               
                                <div class="col-sm-4">                             
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="admin/images/<?php echo $key['pro_image'] ?>" alt="" width = "300" height="300" />
                                                <h2><?php echo number_format($key['price'],0) . "₫"?></h2>
                                                <p><?php echo $key['name'] ?></p>
                                                <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                <h2><?php echo number_format($key['price'],0) . "₫" ?></h2>
                                                <p><a href="detail.php?id=<?php echo $key['id'] ?>"><?php echo $key['name'] ?></a></p>
                                                <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                          
                                </div>
                        <?php } } }   
                        elseif (isset($_GET['type_id'])) {   
                        $type_id = $_GET['type_id'];
                        foreach ($prod as $key) {
                            if($key['type_id'] == $type_id)
                            {
                        ?>  
                                <div class="col-sm-4">                             
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="admin/images/<?php echo $key['pro_image'] ?>" alt="" width = "300" height="300" />
                                                <h2><?php echo number_format($key['price'],0) . "₫"?></h2>
                                                <p><?php echo $key['name'] ?></p>
                                                <a href="insertcard.php?id=<?php echo $key['id']?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                <h2><?php echo number_format($key['price'],0) . "₫" ?></h2>
                                                <p><a href="detail.php?id=<?php echo $key['id']?>"><?php echo $key['name'] ?></a></p>
                                                <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                          
                                </div>  
                        <?php } } } 
                        else {
                        foreach ($prod as $key) {                            
                        ?>  
                            <div class="col-sm-4">                             
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="admin/images/<?php echo $key['pro_image'] ?>" alt="" width = "300" height="300" />
                                            <h2><?php echo number_format($key['price'],0) . "₫"?></h2>
                                            <p><?php echo $key['name'] ?></p>
                                            <a href="insertcard.php?id=<?php echo $key['id']?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    <div class="product-overlay">
                                        <div class="overlay-content">
                                            <h2><?php echo number_format($key['price'],0) . "₫" ?></h2>
                                            <p><a href="detail.php?id=<?php echo $key['id']?>"><?php echo $key['name'] ?></a></p>
                                            <a href="insertcard.php?id=<?php echo $key['id'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>                                          
                            </div>                                
                       <?php  } }?>      

