<?php
     
function back2search() 
{
   if(isset($_SESSION['search_results'])) {
      ?>
      <form action="/auction/search.php" method="post" class="back2search">
         <input type="image" src="/auction/images/back2search.gif" />
         <input type="hidden" name="back" value="1" />
      </form>
      <?php
   }
}

?>