<?php
$con = mysqli_connect("localhost","root","","cat-satyam")or die('connection failed');
?>

<?php
$query=mysqli_query($con,"select * from category where parent_id='0'");
$arr=mysqli_fetch_all($query);
echo '<ul>';
foreach($arr as $val)
{
  ?>
   <li> <?php echo $val[1]; ?>
        <?php  echo getChild($con,$val[0]);  ?>
   </li>
  <?php
    
}
echo '</ul>';


function getChild($con,$id)
{
    $query = mysqli_query($con,"select *  from category where parent_id='$id'"); //for get child
    $rows=mysqli_num_rows($query);
    if($rows > 0) // child present
    {
        $childs=mysqli_fetch_all($query);
        echo '<ul>';
        foreach($childs as $child)
        {
         echo '<li>'.$child[1].'</li>';
            getChild($con,$child[0]);
        }
        echo '</ul>';
    }
    else // child  not present
    {
        return 'no child';
    }
}

?>