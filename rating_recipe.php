<?php  

$mydate = getdate(date('U'));
$date = "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]";

$sqlr = $conn->query("SELECT id,userReview FROM review WHERE recipe_id = ".$_GET['id']);
$numR = $sqlr->num_rows;

$arrayReview = array();
for ($i=1; $i < 6 ; $i++) { 
    $arrayReview[$i]['star'] = 0;
    $arrayReview[$i]['percent'] = 0;
}


$totalReview = 0;
if ( $sqlr->num_rows > 0 ){
    while ( $row = $sqlr->fetch_array(MYSQLI_ASSOC) ){
        if ( empty($arrayReview[$row['userReview']]) ){
            $arrayReview[$row['userReview']]['star'] = 1;
        }else{
            $arrayReview[$row['userReview']]['star']++;
        }  
        $totalReview++;      
    }
}

if ( !empty($arrayReview) && $totalReview > 0 ){
    foreach( $arrayReview as $k => $v ){
        $arrayReview[$k]['percent'] = $v['star'] / $totalReview * 100;
    }
}

$sqlr = $conn->query("SELECT SUM(userReview) AS total FROM review WHERE recipe_id = ".$_GET['id']);
$rData = $sqlr->fetch_array();
$total = $rData['total'];

$avg = '';
if($numR != 0) {
    if(is_nan(round(($total / $numR), 1))) {
        $avg = 0;
    }
    else {
        $avg = round(($total / $numR), 1);
    }
}
else {
    $avg = 0;
}


?>
    <div class="container">
        <section class="rating-review" id="ratingSection">
            <div class="tri table-flex">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="rnb rvl">
                                    <h3><?php echo $avg; ?>/5.0</h3>
                                </div>
                                <div class="pdt-rate">
                                    <div class="pro-rating">
                                        <div class="clearfix rating marT8 ">
                                            <div class="rating-stars ">
                                                <div class="grey-stars"></div>
                                                <div class="filled-stars" style="width:<?php echo ($avg * 20) ?>%"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rnrn">
                                    <p class="rars"> <?php if($numR == 0){echo "No";}else{echo $numR;}; ?> Review(s)</p>
                                </div>
                            </td>
                            <td>
                                <div class="rpb">
                                    <div class="rnpb">
                                        <label>5 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:<?php echo $arrayReview[5]['percent']; ?>%"></div>
                                            
                                        </div>
                                        <label>(<?php echo $arrayReview[5]['star']; ?>)</label>
                                    </div>
                                    <div class="rnpb">
                                        <label>4 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:<?php echo $arrayReview[4]['percent']; ?>%"></div>
                                        </div>
                                        <label>(<?php echo $arrayReview[4]['star']; ?>)</label>
                                    </div>
                                    <div class="rnpb">
                                        <label>3 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:<?php echo $arrayReview[3]['percent']; ?>%"></div>
                                        </div>
                                        <label>(<?php echo $arrayReview[3]['star']; ?>)</label>
                                    </div>
                                    <div class="rnpb">
                                        <label>2 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:<?php echo $arrayReview[2]['percent']; ?>%"></div>
                                        </div>
                                        <label>(<?php echo $arrayReview[2]['star']; ?>)</label>
                                    </div>
                                    <div class="rnpb">
                                        <label>1 <i class="fa fa-star"></i></label>
                                        <div class="ropb">
                                            <div class="ripb" style="width:<?php echo $arrayReview[1]['percent']; ?>%"></div>
                                        </div>
                                        <label>(<?php echo $arrayReview[1]['star']; ?>)</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="rrb">
                                    <p>Rate & Review Our Recipe!</p>
                                    <button class="rbtn opmd">Review</button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="review-modal" style="display:none">
                    <div class="review-bg"></div>
                    <div class="rmp">

                        <div class="rpc">
                            <span><i class="far fa-times"></i></span>
                        </div>
                        <div class="rps" align="center">
                            <i class="fa fa-star" data-index="0" style="display:none"></i>
                            <i class="fa fa-star" data-index="1"></i>
                            <i class="fa fa-star" data-index="2"></i>
                            <i class="fa fa-star" data-index="3"></i>
                            <i class="fa fa-star" data-index="4"></i>
                            <i class="fa fa-star" data-index="5"></i>
                        </div>
                        <input type="hidden" value="" class="starRateV">
                        <input type="hidden" value="<?php echo $date ?>" class="rateDate">

                        <div class="rptf" align="center">
                            <input type="text" class="raterName" value="<?php echo $_SESSION["username"];?>" readonly>
                        </div>

                        <div class="rptf" align="center">
                            <textarea name="rate-field" id="rate-field" class="rateMsg"
                                placeholder="Describe Your Experience (optional)"></textarea>
                        </div>
                        <div class="rate-error" align="center"></div>
                        <div class="rpsb" align="center">
                            <button class="rpbtn" style="color: black;">Add Review</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bri">
                <div class="uscm">
                    <?php
                        $sqlp = "SELECT * FROM review WHERE recipe_id = ".$_GET['id'];
                        $resultp = $conn -> query($sqlp);
                        if(mysqli_num_rows($resultp) > 0) {
                            while($row = $resultp -> fetch_assoc()) {
                       ?>
                    <div class="uscm-secs">
                        <div class="us-img">
                            <p><?= substr($row['userName'], 0, 1); ?></p>
                        </div>
                        <div class="uscms">
                            <div class="us-rate">
                                <div class="pdt-rate">
                                    <div class="pro-rating">
                                        <div class="clearfix rating marT8 ">
                                            <div class="rating-stars ">
                                                <div class="grey-stars"></div>
                                                <div class="filled-stars" style="width:<?= $row['userReview'] * 20 ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="us-cmt">
                                <p><?= $row['userMessage'] ?></p>
                            </div>
                            <div class="us-nm">
                                <p><i> By <span class="cmnm"><?= $row['userName'] ?></span> on <span
                                            class="cmdt"><?= $row['dateReviewed'] ?></span> </i></p>
                            </div>
                        </div>
                    </div>
                    <?php 
                            }
                        }
                                
                            ?>


                </div>
            </div>
        </section>
  
    </div>
    <!-- <script src="js/main-vanila.js"></script> -->
    
<!-- </body>

</html> -->