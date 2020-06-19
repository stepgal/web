<?php
@session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/jquery.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/main.js"></script>


        <script>
            function deleteItem(id) {
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {action:'delete', id: id},
                    success:function(html) {
                        location.reload();
                    }
                });
            }
            function addItem(id, title, description, cost) {
                console.log("userid = " + id)
                if(id === "") {
                    alert("UserId is empty!");
                    return;
                }
                if(title === "") {
                    alert("Title is empty!");
                    return;
                }
                if(description === "") {
                    alert("Description is empty!");
                    return;
                }
                if(cost === "") {
                    alert("Cost is empty!");
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {action:'add', userId: id, title:title, description:description, cost:cost },
                    success:function(html) {
                        location.reload();
                    },
                    error: function(data) {
                        alert("error");
                    }
                });
            }
        </script>
    </head>
    <body>
<?php
	$error = '';
	if(isset($_GET['ac']) && $_GET['ac'] == 'logout'){
		$_SESSION['user_info'] = null;
		unset($_SESSION['user_info']);
	}
?>
	<?php
    if(isset($_SESSION['user_info']) && is_array($_SESSION['user_info'])) { ?>
        <form id="login-form1" class="login-form1" name="form1">
            <div id="form-content">
                <div class="welcome">
                    You are logged in. <a href="index.php?ac=logout" style="color:#3ec038">Logout</a>
                </div>
            </div>
        </form>
        <?php
        $userId = $_SESSION['user_info']['_id'];
        $url = 'http://3.15.18.44:3002/items/'.$userId;
        $response = file_get_contents($url);
        $response = json_decode($response,true);
        $items = $response['items'];
        ?>
        <div class="my-list">
            <div class="rTable">
                <div class="rTableHead"><strong>Title</strong></div>
                <div class="rTableHead"><strong>Description</strong></div>
                <div class="rTableHead"><strong>Cost</strong></div>
                <div class="rTableHead"></div>
                <div class="rTableRow">
                    <div class="rTableCell">
                        <input id="Title" name="Title" type="text" placeholder="Item title">
                    </div>
                    <div class="rTableCell">
                        <input id="Description" name="Description" type="text" placeholder="Item Description">
                    </div>
                    <div class="rTableCell">
                        <input id="Cost" name="Cost" type="text" placeholder="Item Cost">
                    </div>
                    <div class="rTableCell">
                        <div class="group submit">
                            <label class="empty"></label>
                            <div>
                                <input name="delete" class="button" type="submit" value="Add New Item" onclick="addItem(
                                    '<?php echo $userId; ?>',
                                        encodeURIComponent(document.getElementById('Title').value),
                                        encodeURIComponent(document.getElementById('Description').value),
                                    document.getElementById('Cost').value
                                    )"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            foreach ($items as $item) {?>
                <div class="rTableRow">
                    <div class="rTableCell"><?php echo $item['title']; ?></div>
                    <div class="rTableCell"><?php echo $item['description']; ?></div>
                    <div class="rTableCell"><?php echo $item['cost']; ?></div>
                    <div class="rTableCell">
                        <div class="group submit">
                            <label class="empty"></label>
                            <div>
                                <input name="delete" class="button" type="submit" value="Delete" onclick="deleteItem('<?php echo $item['_id']; ?>')"/>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
        </div>
	 <?php } else { ?>
	    <form id="login-form" class="login-form" name="form1" method="post" action="index.php">
	    	<input type="hidden" name="is_login" value="1">
	        <div class="h1">Login Form</div>
	        <div id="form-content">
	            <div class="group">
	                <label for="email">Email</label>
	                <div><input id="email" name="email" class="form-control required" type="email" placeholder="Email"></div>
	            </div>
	           <div class="group">
	                <label for="name">Password</label>
	                <div><input id="password" name="password" class="form-control required" type="password" placeholder="Password"></div>
	            </div>
	            <?php if($error) { ?>
	                <em>
						<label class="err" for="password" generated="true" style="display: block;"><?php echo $error ?></label>
					</em>
				<?php } ?>
	            <div class="group submit">
	                <label class="empty"></label>
	                <div><input name="submit" type="submit" value="Submit"/></div>
	            </div>
	        </div>
	        <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
	    </form>
	<?php } ?>   
    </body>
</html>
