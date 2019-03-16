<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="css/pagination.css" rel="stylesheet" type="text/css">
    <link href="css/my.css" rel="stylesheet" type="text/css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>    
    <script src="js/js-webshim/minified/polyfiller.js"></script>
    <script src="js/pagination.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- TODO: Change title-->
    <title>Your Title</title>

    <!-- TODO: Change favicon -->
    <link rel="shortcut icon" type="image/png" href="./images/ficon.png"/>
    
    <script type="text/javascript">

      // checkbox validation and tooltip control
  		webshim.activeLang('en');
      webshims.polyfill('forms');
      webshims.cfg.no$Switch = true;
      webshim.setOptions('forms', { addValidators: true });

      $(document).ready(function(){
        $('input:checkbox').tooltip({
          placement: "top",
          trigger: 'hover'
        });

        $('input:checkbox').on('show.bs.tooltip change', function (e) {
            $this = $(this);
            if (e.type == 'show' && $this.is(":checked")) {
                e.preventDefault();
            } else if (e.type == 'change') {
                $this.is(":checked") ? $this.tooltip('hide') : $this.tooltip('show');
            }
        });  
      });


      // contributors pagination control, please refer https://pagination.js.org
  		$(function() { (function(name) {
		    var container = $('#pagination-' + name);

        // TODO: Change contributors list document (.txt)
        // E.g. Id_01$$$Title_01\n (Please refer to your_contributors_list.txt)
		    <?php

		    $file = fopen("your_contributors_list.txt", "r") or die("Unable to open file!");

		    $arr = array();
			
  			while(!feof($file)) {
  				$t = explode('$$$', fgets($file));
  				$arr[$t[0]] = $t[1];
  			}
  			fclose($file);

  			array_pop($arr);

  			echo 'var sources = function () {
  		      					var result = [';
  		    foreach ($arr as $key => $value) {
  	    		$value = preg_replace('/\s+/', ' ', trim($value));
  	    		$sent = "[\"". $key ."\",\"". $value ."\"], ";
  	    		echo $sent;
  		    }

  		    echo ']; return result; }();';

  			?>
  		  
        // TODO: Change appreciation message and list item format
        // We provided arxiv's link of each paper's title 
        // dataSource format = [[id1, title1], [id2, title2], [id3, title3], [id4, title4], ...] (an array of array)
  		  var t_num = sources.length;			
  		  $("#number_of_researchers").text("We special thank to " + t_num  + " researchers for annotating thier works.");	   
  	 
		    var options = {
		      dataSource: sources,
 		      pageSize: 30,
		      callback: function (response, pagination) {
		        var dataHtml = '<ul>';
		        $.each(response, function (index, item) {
              // TODO: list item format
				      dataHtml += '<li>' + ' [' + item[0] + '] - <a href="https://arxiv.org/abs/' + item[0] + '">' + item[1] + '</a></li>';
		        });
		        dataHtml += '</ul>';
		        container.prev().html(dataHtml);
		      }
		    };
  		    
		    container.pagination(options);
  		  })('container');
  		})
    </script>

</head>

<body>
        <br>
    <div class="container">
        <!-- TODO: Change to project title -->
        <h1>Your Title</h1>
        <br>
        <!-- TODO: Change nav tab's name -->
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Motivations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu3">Contributors</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Contact Us</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane container active" id="home">
                <?php

                # Some php utilities function

                function printHomeHTML() {
                  # TODO: Change home page message
                  echo '<div class="row">
                          <div class="col-12">
                            <br>
                            <div class="jumbotron shadow-lg bg-white">
                              <h1 style="text-align:center; font-family: Rockwell,Courier Bold,Courier,Georgia,Times,Times New Roman,serif;">Knowledge is power.<br><small>Knowledge shared is</small><br><b>POWER<br>MULTIPLIED.</b></h1>
                              <h6 style="text-align:center; color:#696969; font-family: Rockwell,Courier Bold,Courier,Georgia,Times,Times New Roman,serif;">by Robert Noyce</h6>
                            </div>
                          </div>
                        </div>';
                }

                function printAppreciationHTML() {
                  # TODO: Change appreciation message
                  echo '<div class="row">
                          <div class="col-12">
                            <br>
                            <div class="jumbotron shadow-lg bg-white">
                              <h3>We really appreciate your kind help!</h3>
                              <p align="justify" style="color:#696969;">If you need further information about this project, please don\'t hesitate to contact us &#128516. <br> We\'ll notify you when this dataset is ready.</p>
                            </div>
                          </div>
                        </div>';
                }

                # TODO: Change error log text file
                function log_error($message) {
                  $stderr = fopen('your_error_log.txt', 'a'); 
                  fwrite($stderr, $message."\n"); 
                  fclose($stderr);
                }

                # TODO: Change to the directory which you save your data
                function is_file_exists($filename) {
                  $file = './your_data_path/'.$filename;

                  return file_exists($file);
                }

            		function log_req($message, $path) {
            		  $stderr = fopen($path, 'a');
            		  fwrite($stderr, $message."\n");
                              fclose($stderr);
            		}

            		function get_ips() {
            		  $ip = getenv('HTTP_CLIENT_IP')?:
                        	getenv('HTTP_X_FORWARDED_FOR')?:
                        	getenv('HTTP_X_FORWARDED')?:
                        	getenv('HTTP_FORWARDED_FOR')?:
                        	getenv('HTTP_FORWARDED')?:
                        	getenv('REMOTE_ADDR');
            		  return $ip;
            		}

            		function debug_to_console( $data ) {
                		  $output = $data;
                		  if ( is_array( $output ) )
                    		$output = implode( ',', $output);

                		  echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
            		}

                # RESTFul API 
                if ($_SERVER['REQUEST_METHOD'] == 'GET'){

                  if (isset($_GET['id'])) {

                    $id = $_GET['id'];

                    # TODO: Change submitted result file name
                    if (is_file_exists($id.'_your_output_file_name.txt') || is_file_exists($id.'your_output_file_with_failed_csrf_name.txt')){
                      # show appreciation
                      printAppreciationHTML();

                      # TODO: Change input file name
                    } elseif (is_file_exists($id.'_your_input_file_name.txt')){
                      # TODO: Change input file path
                      $file = fopen('./your_data_path/'. $id .'_your_input_file_name.txt', "r") or die("Unable to open file!");
                      
                      ### TODO: Change input file format
                      # Our format:
                      # Line 1: Author_name$$$Title
                      # Line 2: Abstract (each sentence joined using $$$)
                      #
                      # First line
                      $pieces = explode("$$$", fgets($file));
                      $author = $pieces[0];
                      $title = $pieces[1];
                      $title = str_replace("\n", '', $title);

                      # Second line
                      $abstract = fgets($file);
                      $abstracts = explode("$$$", $abstract);

                      fclose($file);
                      ### END
   
                      if (empty($_SESSION['csrf_token'])) {
                      	  if (function_exists('mcrypt_create_iv')){
                   			  	$_SESSION['csrf_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                  			  }else{
                   			  	$_SESSION['csrf_token'] =  bin2hex(openssl_random_pseudo_bytes(32));
                  			  }
            		      }
                      $csrf_token = $_SESSION['csrf_token'];

                      # TODO: Change submission message
                      $submit_message = 'Do you really want to submit the form?';

                      ### TODO: Change form
                      echo '<div class="row">
                              <div class="col-12">
                                <br>
                                <h3>"'. $title .'"</h3>
                                <br>
                              </div>
                            </div>';

                      echo '<div class="row">
                              <div class="col-12">
                                <!-- TODO: Change form submission -->
                                <form action="abstract.php" method="POST" name="'. $id .'" onsubmit="return confirm(\''. $submit_message .'\');">
                                    <input type="hidden" id="hidden_id" name="id" value="'. $id .'">
                                    <input type="hidden" id="hidden_token" name="csrf_token" value="'. $csrf_token .'">

                                    <!-- TODO: Change to your task-->
                                    <div id="label_accordion">
                                      <div class="card shadow-lg">
                                        <div class="card-header">
                                          <a class="card-link" data-toggle="collapse" href="#label-tips">
                                              <b>TASK 1&#160;</b>  <span class="badge badge-pill badge-danger">DEFINITION - Click Me</span>
                                          </a>
                                        </div>
                                        <div id="label-tips" class="collapse show" data-parent="#label_accordion">
                                          <div class="card-body">
                                              <!-- TODO: To give more explaination on your task starting from here -->
                                              <p>In this dataset, we classify each sentence in the abstract into <b>one</b> or <b>more</b> of the six classes as below,</p>
                                              <dl>
                                                  <dt>BG - Background</dt>
                                                  <dd>- Background describes what is already known about the subject, related to the paper in question.</dd>
                                                  <dt>OBJ - Objectives</dt>
                                                  <dd>- Objective describes what is not known about the subject and hence what the study intended to examine (or what the paper seeks to present).</dd>
                                                  <dt>METH - Methods</dt>
                                                  <dd>- Methods describe how you conducted your project. What was the research design? or What algorithms/technologies were used in the research? etc.</dd>
                                                  <dt>RSLT - Results</dt>
                                                  <dd>- Results should contain as much detail about the findings.</dd>
                                                  <dt>CON - Conclusions</dt>
                                                  <dd>- Conclusions should contain the most important take-home message of the study, expressed in a few precisely worded sentences.</dd>
                                                  <dt>OTR - Others</dt>
                                                  <dd>- None of above.</dd>
                                              </dl>
                                              <footer class="blockquote-footer">Definition reference: <cite>How to write a good abstract for a scientific paper or conference presentation</cite></footer>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <table class="table table-hover table-bordered shadow-lg" width="100%">
                                        <col style="width:58%">
                                        <col style="width:7%">
                                        <col style="width:7%">
                                        <col style="width:7%">
                                        <col style="width:7%">
                                        <col style="width:7%">
                                        <col style="width:7%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Sentence</th>
                                                <th>BG</th>
                                                <th>OBJ</th>
                                                <th>METH</th>
                                                <th>RSLT</th>
                                                <th>CON</th>
                                                <th>OTR</th>
                                            </tr>
                                        </thead>

                                        <tbody>';

                                        ### TODO: Change to your submission format (remember to change at PHP POST as well)
                                        # (use editor CRTL-F "find" to search SAVE_1)
                                        # if you change the "name" remember to change at POST request to.
                                        $counter = 1;
                                        foreach ($abstracts as $sent) {
                                          echo '<tr>
                                                  <td>'. $sent .'</td>

                                                  <td><input type="checkbox" data-grouprequired name="'. $counter .'[]" value="BACKGROUND" id="BACKGROUND" title="BACKGROUND" data-toggle="tooltip"/></td>

                                                  <td><input type="checkbox" name="'. $counter .'[]" value="OBJECTIVE" id="OBJECTIVES" title="OBJECTIVES" data-toggle="tooltip"/></td>

                                                  <td><input type="checkbox" name="'. $counter .'[]" value="METHODS" id="METHODS" title="METHODS" data-toggle="tooltip"/></td>

                                                  <td><input type="checkbox" name="'. $counter .'[]" value="RESULTS" id="RESULTS" title="RESULTS" data-toggle="tooltip"/></td>

                                                  <td><input type="checkbox" name="'. $counter .'[]" value="CONCLUSIONS" id="CONCLUSIONS" title="CONCLUSIONS" data-toggle="tooltip"/></td>

                                                  <td><input type="checkbox" name="'. $counter .'[]" value="OTHERS" id="OTHERS" title="OTHERS" data-toggle="tooltip"/></td>
                                              </tr>';
                                          $counter += 1;
                                        }

                              echo '   </tbody>

                              </table>

                              <!-- TODO: Change to your task-->
                              <div id="type_accordion">
                                <div class="card shadow-lg">
                                  <div class="card-header">
                                    <a class="card-link" data-toggle="collapse" href="#type-tips">
                                        <b>TASK 2&#160;</b>  <span class="badge badge-pill badge-danger">DEFINITION - Click Me</span>
                                    </a>
                                  </div>
                                  <div id="type-tips" class="collapse show" data-parent="#type_accordion">
                                    <div class="card-body">
                                        <!-- TODO: To give more explaination on your task starting from here -->
                                        <p>In this dataset, we classify each paper into <b>one</b> or <b>more</b> of the four classes as below,</p>
                                        <dl>
                                            <dt>Theoretical Paper</dt>
                                            <dd>- A theoretical paper describes a theory or algorithm or provides a mathematical proof for some hypothesis.</dd>
                                            <dt>Engineering Paper</dt>
                                            <dd>- An engineering paper describes an implementation of an algorithm, or part or all of a computer system or application. Engineering papers are now frequently required to include descriptions of system evaluation.</dd>
                                            <dt>Empirical Paper</dt>
                                            <dd>- An empirical paper describes an experiment designed to test some hypothesis (more than one).</dd>
                                            <dt>Others</dt>
                                            <dd>- None of above.</dd>
                                        </dl>
                                        <footer class="blockquote-footer">Definition reference: <cite>How to Read a Computer Science Research Paper</cite></footer>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <table class="table table-hover table-bordered shadow-lg">
                                  <thead class="thead-dark">
                                      <tr>
                                          <!-- TODO: Change to your submission format (remember to change at PHP POST as well) -->
                                          <!-- (use editor CRTL-F "find" to search SAVE_1) -->
                                          <!-- if you change the "name" remember to change at POST request to. -->
                                          <th>Paper types</th>
                                          <th>
                                              <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                      <input class="form-check-input" data-grouprequired type="checkbox" name="type[]" value="1" id="TYPE" title="Theoretical Paper"/>Theoretical Paper
                                                  </label>
                                              </div>
                                              <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                      <input class="form-check-input" type="checkbox" name="type[]" value="2" id="TYPE" title="Engineering Paper"/>Engineering Paper
                                                  </label>
                                              </div>
                                              <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                      <input class="form-check-input" type="checkbox" name="type[]" value="3" id="TYPE" title="Empirical Paper"/>Empirical Paper
                                                  </label>
                                              </div>
                                              <div class="form-check-inline">
                                                  <label class="form-check-label">
                                                      <input class="form-check-input" type="checkbox" name="type[]" value="4" id="TYPE" title="Others"/>Others
                                                  </label>
                                              </div>
                                          </th>
                                      </tr>
                                  </thead>
                              </table>

                              <div class="jumbotron shadow-lg bg-white" style="padding: 5px;">
                              	<div class="col-12 form-group shadow-textarea">
                              		<br>
                  					    	<label for="comment"><h4><b>Comment (optional)</b></h4></label>
                  					    	<textarea class="form-control z-depth-1" rows="5" id="comment" name="comment" placeholder="Any comments or suggestions?"></textarea>
                  					    </div>
                            </div>

                              <input type="submit" id="submit" value="SUBMIT" class="btn btn-success btn-block button2" name="submit"/>
                          </form>
                        </div>
                    </div>';
                    ### END

                    } else {
                      # Log file id not found
                      $ip = getenv('HTTP_CLIENT_IP')?:
                      getenv('HTTP_X_FORWARDED_FOR')?:
                      getenv('HTTP_X_FORWARDED')?:
                      getenv('HTTP_FORWARDED_FOR')?:
                      getenv('HTTP_FORWARDED')?:
                      getenv('REMOTE_ADDR');

                      log_error('File id not found! IP - '. $ip . ' ,id=' . $id);

                      # TODO: Change id not found message
                      echo '<div class="row">
                              <div class="col-12">
                                <br>
                                <div class="jumbotron shadow-lg bg-white">
                                  <h1 style="text-align:center;">File id not found.</h1>
                                  <h6 style="text-align:center; color:#696969;">Please contact us for help.</h6>
                                </div>
                             </div>
                            </div>';
                    }
                  } else {
                    printHomeHTML();
                  }

                # Submitted form control
                } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

                  if (isset($_POST['id']) and isset($_POST['csrf_token'])){

                    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

                      $id = $_POST['id'];

                      ksort($_POST);

                      ### TODO: Change input file directory name (it is same as 'GET')
                      # Read title and abstract
                      $file = fopen('./your_data_path/'. $id .'_your_input_file_name.txt', "r") or die("Unable to open file!");
                      
                      # First line
                      $pieces = explode("$$$", fgets($file));
                      $author = $pieces[0];
                      $title = $pieces[1];
                      $title = str_replace("\n", '', $title);

                      # Second line
                      $abstract = fgets($file);

                      fclose($file);
                      ### END

                      ### TODO: Change output file directory name (name: SAVE_1 <- ignore it)
                      # We save the result as hased_id_your_output_file_name.txt
                      # Our output file format:
                      # Line 1: Title$$$type (e.g. if type is 1 and 3 then it should look like Title$$$1 3\n)
                      # Line 2: Abstract sentences same as input file
                      # Line 3: Sentence labels. The number of labels should as same as number of sentences in abstract. Multilabels are saved with backslash (e.g. BACKGROUND/OBJECTIVES, please refer to output_example.txt)
                      # Write POST
                      $file = fopen('./your_data_path/'. $id .'_your_output_file_name.txt', "w");

                      # type
                      fwrite($file, $title.'$$$');
                      foreach ($_POST['type'] as $v){
                        fwrite($file, $v.' ');
                      }
                      fwrite($file, "\n");

                      # abstract
                      fwrite($file, $abstract);

                      # labels
                      foreach($_POST as $key => $value) {
                        if ($key != 'submit' && $key != 'type' && $key != 'id' && $key != 'csrf_token' && $key != 'comment') {
                          foreach ($value as $v){
                            if ($v === end($value)) {
                              fwrite($file, $v);
                            }else{
                              fwrite($file, $v.'\\');
                            }
                          }
                          fwrite($file, ' ');
                        }
                      }
                      fwrite($file, "\n");

                      fclose($file);
                      ### END

                      ### TODO: Change feedback/comment directory name
                      # if any comment, save it
                      if (!empty($_POST['comment'])){
                      	$file = fopen('./your_comment_path/'. $id .'_your_input_file_name.txt', "w");

                      	fwrite($file, $_POST['comment']."\n");
                      	fclose($file);
                      }
                      ### END

                      # show appreciation
                      printAppreciationHTML();

                    } else {
                      # If csrf verfication failed, we log it as an error.
                      # We still save the submitted answer/output for further investigation
                      // Log this as a warning and keep an eye on these attempts
                      $ip = getenv('HTTP_CLIENT_IP')?:
                      getenv('HTTP_X_FORWARDED_FOR')?:
                      getenv('HTTP_X_FORWARDED')?:
                      getenv('HTTP_FORWARDED_FOR')?:
                      getenv('HTTP_FORWARDED')?:
                      getenv('REMOTE_ADDR');

                      log_error('CSFT_token not provided! IP - '.$ip);

		                  $id = $_POST['id'];

                      ksort($_POST);

                      ### TODO: SAME as the above (use editor 'find' to search SAVE_1)
                      # Read title and abstract
                      $file = fopen('./your_data_path/'. $id .'_your_input_file_name.txt', "r") or die("Unable to open file!");

                      # First line
                      $pieces = explode("$$$", fgets($file));
                      $author = $pieces[0];
                      $title = $pieces[1];
                      $title = str_replace("\n", '', $title);

                      # Second line
                      $abstract = fgets($file);

                      fclose($file);

                      # Write POST
                      $file = fopen('./your_data_path/'. $id .'your_output_file_with_failed_csrf_name.txt', "w");

                      # type
                      fwrite($file, $title.'$$$');
                      foreach ($_POST['type'] as $v){
                        fwrite($file, $v.' ');
                      }
                      fwrite($file, "\n");

                      # abstract
                      fwrite($file, $abstract);

                      # labels
                      foreach($_POST as $key => $value) {
                        if ($key != 'submit' && $key != 'type' && $key != 'id' && $key != 'csrf_token'  && $key != 'comment') {
                          foreach ($value as $v){
                            if ($v === end($value)) {
                              fwrite($file, $v);
                            }else{
                              fwrite($file, $v.'\\');
                            }
                          }
                          fwrite($file, ' ');
                        }
                      }
                      fwrite($file, "\n");

                      fclose($file);

                      # if any comment, save it
                      if (!empty($_POST['comment'])){
                      	$file = fopen('./your_comment_path/'. $id .'_your_input_file_name.txt', "w");

                      	fwrite($file, $_POST['comment']."\n");
                      	fclose($file);
                      }
                      ### END

		                  # show appreciation
                      printAppreciationHTML();
                    }

                  } else {
                    printHomeHTML();
                  }

                } else {
                  printHomeHTML();
                }

                ?>
            </div>

            <div class="tab-pane container fade" id="menu1">
                <div class="row">
                    <div class="col-12">
                        <br>
                        <div class="jumbotron shadow-lg bg-white">
                            <!-- TODO: Change to your mission/vision -->
                            <h1 style="text-align:center;">- Our Mission -</h1>
                            <h5 style="text-align:center; color:#696969;">Your mission and vission</h5>
                            <br>
                            <p align="justify" style="color:#808080;">More information.</p>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane container fade" id="menu3">
                <div class="row">
                    <div class="col-12">
                        <br>
                        <div class="jumbotron shadow-lg bg-white">
                            <!-- TODO: Contributors tab -->
                            <h1 style="text-align:center;">- Contributors -</h1>
                            <h5 id="number_of_researchers" style="text-align:center; color:#696969;"></h5>
                  			    <div id="update_time">			    
                  				    <p style="text-align:right; margin-right:15px;"><small>Update every 5 min.</small></p>
                  			    </div>
              							<div id="wrapper">
              							    <section>
              							        <div id="data-container" class="data-container col-12"></div>
              							        <div id="pagination-container" class="col-12"></div>
              							    </section>
              							</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TODO: Contact US tab-->
            <div class="tab-pane container fade" id="menu2">
                <br>
                <div class="row">
                    <div class="col-3">
                        <div class="card shadow-lg">
                            <img class="card-img-bottom" src="./images/img_avatar3.png" alt="Card image" style="width:100%">
                            <div class="card-body">
                                <h4 class="card-title">Name 1</h4>
                                <p class="card-text">
                                    <small>
                                    <a href="#">Department 1</a>
                                    <br>
                                    <a href="#">University 1</a>
                                    </small>
                                </p>
                                <p class="card-text">Email:<br><a href="mailto:#">Email 1</a></p>
                                <a href="#" class="btn btn-primary">See Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h4 class="card-title">Name 2</h4>
                                <p class="card-text"><small><cite>- Title 2</cite></small></p>
                                <p class="card-text">
                                    <small>
                                    <a href="#">Department 2</a>
                                    <br>
                                    <a href="#">University 2</a>
                                    </small>
                                </p>
                                <p class="card-text">Email:<br><a href="mailto:#">Email 2</a></p>
                            </div>
                            <img class="card-img-bottom" src="./images/img_avatar3.png" alt="Card image" style="width:100%">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow-lg">
                            <img class="card-img-top" src="./images/img_avatar3.png" alt="Card image" style="width:100%">
                            <div class="card-body">
                                <h4 class="card-title">Name 3</h4>
                                <p class="card-text"><small><cite>- Title 3</cite></small></p>
                                <p class="card-text">
                                    <small>
                                    <a href="#">Department 3</a>
                                    <br>
                                    <a href="#">University 3</a>
                                    </small>
                                </p>
                                <p class="card-text">Email:<br><a href="mailto:#">Email 3</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h4 class="card-title">Name 4</h4>
                                <p class="card-text"><small><cite>- Title 4</cite></small></p>
                                <p class="card-text">
                                    <small>
                                    <a href="#">Department 4</a>
                                    <br>
                                    <a href="#">University 4</a>
                                    </small>
                                </p>
                                <p class="card-text">Email:<br><a href="mailto:#">Email 4</a></p>
                            </div>
                            <img class="card-img-bottom" src="./images/img_avatar3.png" alt="Card image" style="width:100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</body>

<!-- TODO: Change your license -->
<footer class="page-footer font-small grey darken-4" style="bottom:0;">
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
    <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/88x31.png"/></a> This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.
  </div>
  <!-- Copyright -->
</footer>
</html>
