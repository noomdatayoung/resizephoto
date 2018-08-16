<style>
img {
    max-width: 100%;
	cursor: pointer;
	}
	#imgd {
	width:100px;
	}
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 0px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        //overflow-y: hidden; 

}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0.1)} 
    to {transform:scale(1)}
}
/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

</style> 


<div id="myModal" class="modal">
  <span class="close">X</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
<?
$offset = 0; //get this as input from the user, probably as a GET from a link
$perpage = 10; //number of items to display
if (IsSet($_GET["page"])) $page = (int)$_GET['page']; else $page=0;
if(!($page>=0)) $page = 1;
$dir="ss/";
$filelist = scandir($dir);
 unset($filelist[array_search('.', $filelist, true)]);
    unset($filelist[array_search('..', $filelist, true)]);
$total_files= count($filelist);
$total_pages = ceil($total_files/$perpage);
if ($page>$total_pages) $page=$total_pages;
$offset = ($page-1)*$perpage;
if ($offset<=0) $offset=0;
$page_number = 1;
$count = 10;
$start_from = ($page_number ) * 10;
$end = $start_from + $count;

//get subset of file array
$selectedFiles = array_slice($filelist, $offset, $perpage);

echo "TOT:$total_pages:";
echo $total_files;
echo ":P:$page:s:$start_from:o:$offset:p:$perpage:end:$end";
//output appropriate items
if ($page<=1) $page=1;
if (($page-1)==0) $pageb=1;else $pageb=$page-1;
?>
<div>
    SHOWING: <?=$offset?>-<?=($offset+$perpage)?>  of <?=$total_files?> files
</div>
<a class="page" href="?page=1">
   First</a>
    <a class="page" href="?page=<? echo $pageb;?>">
   <<</a>||
   <a class="page" href="?page=<? echo $page+1;?>">
   >></a>
   <a class="page" href="?page=<? echo $total_pages;?>">
   Last</a>
   <hr>
      <script>
   var start = null;
 window.addEventListener("touchstart",function(event){
   if(event.touches.length === 1){
      //just one finger touched
      start = event.touches.item(0).clientX;
    }else{
      //a second finger hit the screen, abort the touch
      start = null;
    }
  });
   window.addEventListener("touchend",function(event){
    var offset = 100;//at least 100px are a swipe
    if(start){
      //the only finger that hit the screen left it
      var end = event.changedTouches.item(0).clientX;

      if(end > start + offset){
       //a left -> right swipe
       window.location = "?page=<? echo $page+1;?>";
      }
      if(end < start - offset ){
       //a right -> left swipe
       window.location = "?page=<? echo $page-1;?>";
      }
    }
  });
   </script>
   <script>
function modalu(mee){
	var x = pageXOffset, y = pageYOffset;
	filename=mee;//me.src.split("/").pop(); //pop get the last array
		      var modal = document.getElementById('myModal');
		       modal.style.display = "block";
		      // alert(filename+y);
	      	 var modalImg = document.getElementById("img01");
	         modalImg.src = filename;      
            location.hash=y;
            
	}

// Get the modal
var modal = document.getElementById('myModal');
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
		span.onclick = function() { 
	    modal.style.display = "none";
		//main.style.overflowY = "auto";
	    document.body.style.overflowY = "auto";
        document.body.style.position=""; 
      	var y = location.hash.replace("#","");
        scrollTo(0,y);
      
}

var span3 = document.getElementsByClassName("modal")[0];
// When the user clicks on <span> (x), close the modal
span3.onclick = function() { 
    modal.style.display = "none";
    //main.style.overflowY = "auto";
    document.body.style.overflowY = "auto";
            document.body.style.position=""; 

      	var y = location.hash.replace("#","");
        scrollTo(0,y);  //main.style.overflowY = "hidden";

}
		      
</script>
   <?php
foreach($selectedFiles as $file)
{
	if ($file != "." && $file != "..") 	{
    $ffpath = realpath($file); 
    $ffpath = filesize($dir.$file); 
    $ffpath=number_format($ffpath);
	if (is_dir($file)) {$file="[$file]";$ffpath="";}
	?>
	
	<span id=imgd><img src='ss/<?echo $file;?>' alt='' style=max-width:320;max-height:120 onclick=modalu('sm/<?echo $file;?>');></span>
	<?
	}
}
?>