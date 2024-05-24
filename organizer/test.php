<?php

include('../server/koneksi.php');
include('converter.php');

// session_start();

// if (!isset($_SESSION['logged_in'])) {
//   header('location: login.php');
//   exit;
// }

$id = $_REQUEST['id'];

// campaigns
$queryCampaign = "SELECT campaignId, title, banner, description, campaignDate, location, organizerName from campaign join organizer on campaign.organizerId = organizer.organizerId where campaignId = ? LIMIT 1";

$stmt_details = $conn->prepare($queryCampaign);
$stmt_details->bind_param('s', $id);

if ($stmt_details->execute()) {
    $stmt_details->bind_result($id, $title, $banner, $description, $date, $location, $organizer);
    $stmt_details->store_result();

    if ($stmt_details->num_rows() == 1) {
        $stmt_details->fetch();
    }
}

$day = date("d", strtotime($date));
$month = date("n", strtotime($date));
$year = date("Y", strtotime($date));

$month = convertMonth(1, $month);
?>

<?php


$check = 0;
?>

<?php
// insert comments
if (isset($_POST['submit-comment'])) {
    $comment = $_POST['comment'];

    $queryinsert = "INSERT INTO comments VALUES ('', '$comment', '2024-02-13 00:00:00', 7, 1, NULL)";

    mysqli_query($conn, $queryinsert);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="icon" href="../assets/images/title.png" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="organizer-css/bootstrap5/bootstrap.css" />
    <link rel="stylesheet" href="organizer-css/viewcampaigncss.css" />
</head>

<body class="pb-5 mb-2">
    <div class="container shadow rounded-3 pt-2 pb-4 px-4 mt-5">
        <!-- Back Button -->
        <div class="top-line border-bottom border-warning border-opacity-75 border-2 mb-3">
            <a href="homepage.html">
                <i class="fs-1 link-secondary opacity-75 fa fa-angle-left pt-2 px-2"></i>
            </a>
        </div>

        <div>
            <h1 class="text-center fs-3 mb-4">
                <?php echo $title ?>
            </h1>
            <div class="banner border border-2 border-secondary border-opacity-25 rounded-3" id="banner-container">
                <img id="image-size" class="image-banner rounded-2" src="../assets/images/<?php echo $banner ?>" alt="" />
            </div>
            <div>
                <p class="desc">
                    <?php echo $description ?>
                </p>
            </div>

            <div class="border border-2 border-secondary border-opacity-75 rounded-3 w-100 margin-top-table">
                <table class="w-100">
                    <tr>
                        <th class="border-secondary border-opacity-75 text-center text-secondary fw-medium border-bottom border-2 border-0 pt-1 pb-2" colspan="2">
                            Organizer<br />
                            <span class="fw-normal text-black"> <?php echo $organizer ?></span>
                        </th>
                    </tr>
                    <tr>
                        <th class="border-secondary border-opacity-75 text-center text-secondary fw-medium border-end border-2 border-0 pt-1 pb-2 col-5">
                            Date<br />
                            <span class="fw-normal text-black" id="date"><?php echo $day . " " . $month . " " . $year ?></span>
                        </th>
                        <th class="border-secondary border-opacity-75 text-center text-secondary fw-medium border-start border-2 border-0 pt-1 pb-2 col-5">
                            Location<br />
                            <span class="fw-normal text-black"> <?php echo $location ?></span>
                        </th>
                    </tr>
                </table>
            </div>

            <div class="top-line border-bottom border-warning border-opacity-75 border-2 my-4"></div>
        </div>

        <!-- Button Edit & Delete -->
        <div class="row">
            <div class="col">
                <button class="button-css w-100 rounded-pill bg-info fw-bold text-white border-0">
                    Edit
                </button>
            </div>
            <div class="col">
                <button class="button-css w-100 rounded-pill bg-danger fw-bold text-white border-0">
                    Delete
                </button>
            </div>
        </div>

        <div class="top-line border-bottom border-warning border-opacity-75 border-2 mt-3"></div>

        <!-- Comments -->
        <div>
            <h1 class="fw-medium fs-4 text-secondary mb-2 mt-3">Comments</h1>
            <div class="row">
                <div class="col col-sm-1 text-center">
                    <img src="../assets/images/gen.jpeg" class="image-size rounded-circle" alt="" />
                </div>
                <div class="col">
                    <form action="" method="POST">
                        <textarea name="comment" id="comment" class="text-area w-100 rounded-3 border-secondary border-2 border border-opacity-50 bg-white bg-opacity-10 px-2 fw-normal" maxlength="1000" oninput="countTextComment()" autocomplete="off" placeholder="Write your Comments"></textarea>
                        <div class="d-flex justify-content-between fw-medium text-secondary fs-6 margin-bottom-30 pe-2" id="comment-max">
                            <input type="submit" name="submit-comment" id="submit-comment" onclick="submitClicked()" class="submit-comment rounded-pill border-0 bg-warning bg-opacity-75 mt-1 text-white fw-bold" value="Send">
                            <p class="text-end"><span id="comment-char">0</span>/1000</p>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="border-2 margin-line" />

            <!-- Other Comments -->
            <div>
                <table class="w-100">
                    <?php
                    showComments();
                    function showComments()
                    {
                        include('../server/koneksi.php');
                        $id = $_REQUEST['id'];

                        // show comments
                        $queryComments = "SELECT commentItself as comment, commentDate as date, organizerName as organizer, userName as user
                        from comments 
                        left join organizer on comments.organizerId = organizer.organizerId 
                        left join users on comments.userId = users.userId 
                        where campaignId = $id
                        order by commentDate desc";

                        $result = mysqli_query($conn, $queryComments);

                        $queryrow = "SELECT count(*) from comments where campaignId = $id";
                        $queryrowresult = $conn->prepare($queryrow);

                        if ($queryrowresult->execute()) {
                            $queryrowresult->bind_result($rowcount);
                            $queryrowresult->fetch();
                        }

                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($check = 0) {
                    ?>
                                <tr>
                                    <th class="col-size v-align text-start px-2 name-image-css border-bottom border-0 border-1" rowspan="2">
                                        <img class="image-size rounded-circle" src="../assets/images/gen.jpeg" alt="" />
                                    </th>
                                    <th class="text-black px-2 name-image-css">
                                        <?php if (is_null($row['user'])) {
                                            echo $row['organizer'];
                                        ?>&nbsp;<i class="fa fa-check-circle text-info text-opacity-75"></i>
                                    <?php
                                        } else {
                                            echo $row['user'];
                                        } ?><span class="text-secondary text-opacity-50 fw-normal fs-6"><br /><?php echo $row['date'] ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="text-black fw-normal px-2 pt-1 comment-css">
                                        <?php echo $row['comment'] ?>
                                    </td>
                                </tr>

                            <?php
                                $check = 1;
                            } else { ?>
                                <tr class="border-top border-0 border-1">
                                    <th class="col-size v-align text-start px-2 name-image-css" rowspan="2">
                                        <img class="image-size rounded-circle" src="../assets/images/gen.jpeg" alt="" />
                                    </th>
                                    <th class="text-black px-2 name-image-css">
                                        <?php if (is_null($row['user'])) {
                                            echo $row['organizer'];
                                        ?>&nbsp;&nbsp;<i class="fa fa-check-circle text-info text-opacity-75 pt-1"></i>
                                    <?php
                                        } else {
                                            echo $row['user'];
                                        } ?><span class=" text-secondary text-opacity-50 fw-normal fs-6"><br /><?php echo $row['date'] ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="text-black fw-normal px-2 pt-1 comment-css">
                                        <?php echo $row['comment'] ?>
                                    </td>
                                </tr>
                    <?php }
                        }
                    } ?>
                </table>
            </div>
        </div>
    </div>
    <script src="organizer-js/viewcampaignjs.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $('#submit-comment').click(function() {
            jQuery.ajax({
                type: "POST",
                url: 'test.php',
                dataType: 'json',
                data: {
                    functionname: 'showComments'
                },
                success: function(obj, textstatus) {
                    if (!('error' in obj)) {
                        yourVariable = obj.result;
                    } else {
                        console.log(obj.error);
                    }
                }
            });
        });
    </script>
</body>

</html>