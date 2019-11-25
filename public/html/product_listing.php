<!--when item has been selected, details of the item is presented here-->
<?php require_once ("../../private/initialise.php") ?>

<?php include("../../private/shared/header.php")?>

<?php
$item_id = $_GET['item_id'];

$query = "SELECT * from item where item_id = $item_id";
$query_res = mysqli_query($db, $query);
$item_details = $query_res -> fetch_assoc();

$seller_fk = $item_details ['seller_fk'];
$query = "SELECT username FROM user where user_fk = $seller_fk";
$query_res = mysqli_query($db, $query);
$seller_details = $query_res -> fetch_assoc();


$bidder_fk = $_SESSION['user_id'];
$bid_on_fk = $item_details['item_id'];

?>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">A-Bay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">My Listings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="account.php">Account</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        echo '<a class="nav-link" href="logout.php">Logout</a>';
                    } else {
                        echo '<a class="nav-link" href="login.php">Login</a>';
                    }?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="bidModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle">Make bid</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action= "<?php echo url_for('/html/send_bid_to_db.php')?>" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">£</span>
                            </div>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar) name = "bid_amount">
                            <input type="submit" value="Click here to Submit bid"/>
                        </div>
                </div>
                </form>



            </div>
        </div>
    </div>

    <div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMessage" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle">Contact seller</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name" value="ucabjja">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>

    <div class="input-group my-4">
        <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
        <div class="input-group-append">
            <a class="btn btn-primary" href="search_results.php">Search</a>

            <button class="btn btn-outline-primary search-bar-dropdown-toggle dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
    </div>
    <div class="row my-4">
    <div class="col-sm-5">
            <img id="item-display" src="https://media.karousell.com/media/photos/products/2018/10/06/corsair_gs600_80plus_psu_1538780922_81e254d1.jpg" height="375" width="450" alt=""></img>
    </div>

    <div class="col-sm-7">
        <div class="h5"><?php echo $item_details['item_name'] ?> </div>
        <hr>
        <div class="product-price">Current bid: <span><strong>$ 1234.00</strong></span></div>
        <div class="product-price">Buy it now: <span><strong>$ 2145.00</strong></span></div>
        <div class="btn-group cart">
            <button type="button" class="btn btn-success">
                 Buy now
            </button>
        </div>
        <div class="btn-group cart">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bidModal">
                Make bid
            </button>
        </div>
        <div class="btn-group wishlist my-2">
            <button type="button" class="btn btn-outline-dark">
                Add to wishlist
            </button>
        </div>
        <!-- Card -->

        <div class="card h-40 my-2">

            <!-- Card content -->
            <div class="card-body">
                <!-- Title -->
                <h5 class="card-subtitle"><a><?php echo $seller_details['username'];
                        ?></a></h5>
                <!-- Data -->
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>

                <p class="mb-2">Seller • <?php echo $item_details['location'];?></p>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendMessage">Contact</button>
                <button type="button" class="btn btn-primary">Feedback</button>

            </div>

        </div>
        <!-- Card -->
    </div>
    </div>

    <div class="row my-4">
        <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4>Product Description</h4>
                        <?php echo $item_details['description']?>
                    </div>
                </div>
        </div>
    </div>

    <h4>Recommendations</h4>
    <!-- /.row -->
    <div class="row my-4">

        <div class="col">
            <div class="card h-50">
                <a href="#"><img class="card-img-top" src="http://placehold.it/250x125" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Item Two</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-50">
                <a href="#"><img class="card-img-top" src="http://placehold.it/250x125" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Item Three</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-50">
                <a href="#"><img class="card-img-top" src="http://placehold.it/250x125" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Item Four</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-50">
                <a href="#"><img class="card-img-top" src="http://placehold.it/250x125" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="#">Item Four</a>
                    </h4>
                    <h5>$24.99</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>

    </div>
    <!-- /.row -->
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
