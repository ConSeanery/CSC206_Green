<?php
// Load all application files and configurations
require($_SERVER[ 'DOCUMENT_ROOT' ] . '/../includes/application_includes.php');
// Include the HTML layout class
require_once(FS_TEMPLATES . 'Layout.php');
require_once(FS_TEMPLATES . 'News.php');
// Connect to the database
$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Initialize variables
$requestType = $_SERVER[ 'REQUEST_METHOD' ];
// Generate the HTML for the top of the page
Layout::pageTop('CSC206 Project');
?>

<div class="container top25">
    <div class="col-md-8">
        <section class="content">

            <?php
            if ( $requestType == 'GET' ) {
				if (isset($_SESSION["users"])){
                    
                $sql = 'select * from audio where id = ' . $_GET['id'];
                $result = $db->query($sql);
                $row = $result->fetch();
				

                $id = $row['id'];
                $title= $row['title'];
                $url= $row['url'];
				$author = $row['author'];
				
				
                echo <<<postform
                    <form id="showAudioForm" action='updateAudio.php' method="POST" class="form-horizontal">
        <fieldset>
		<input type="hidden" name="id" value="$id">
    
            <!-- Form Name -->
            <legend>New Audio Link</legend>
    
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="title">Title</label>
                <div class="col-md-8">
                    <input id="title" name="title" type="text" placeholder="post title" value="$title" class="form-control input-md" required="">                    
                </div>
            </div>
			
			 <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="author">Author</label>
                <div class="col-md-8">
                    <textarea class="form-control" id="author" name="author">$author</textarea>
                </div>
            </div>
    
            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="url">URL:</label>
                <div class="col-md-8">
                    <textarea class="form-control" id="url" name="url">$url</textarea>
                </div>
            </div>
    
            <!-- Button (Double) -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-md-8">
                    <button id="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
                </div>
            </div>
    
        </fieldset>
    </form>
postform;
				}
				else{echo '<p>Not Logged in</p>';}		
				
					
            } elseif ( $requestType == 'POST' ) {
                //Validate data
				
                $id = $_POST['id'];
                $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
				$url = htmlspecialchars($_POST['url'], ENT_QUOTES);
				$author = htmlspecialchars($_POST['author'], ENT_QUOTES);
                
                // Save data
                $sql = "update audio set title= '$title', url= '$url', author= '$author' where id=$id;";
                $result = $db->query($sql);
                echo 'This Link was updated successfully';
            }
			
			
				

            ?>


        </section>
    </div>

    <div class="col-md-4">
        
    </div>
</div>




<?php
// Generate the page footer
Layout::pageBottom();
?>