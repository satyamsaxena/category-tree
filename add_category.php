<?php
$con = mysqli_connect("localhost","root","","cat-satyam")or die('connection failed');

if(isset($_POST['submit']))
{
    $parent        =$_POST['parent_id'];
    $category_name =$_POST['name'];
    
    $ins = mysqli_query($con,"insert into category values('','$category_name','$parent')");
    if($ins)
    {
        $msg = "<span style='color:green;font-weight:bolder;'>Category successfully saved</span>";
        header("location.href=add_category.php");
    }
   
}

?>
<html>
<head>
    <title>Categories Solution</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <form method="post">
        <table border="5" align="center" width="50%">
           <tr>
               <th colspan="2" class="text-center"> <?php echo @$msg; ?> </th> 
           </tr>
            <tr>
               <th colspan="2" class="py-3 text-center ">Category SubCategory</th> 
           </tr>
            <tr>
               <th class="py-3 text-center">Parent</th>
                <th class="py-3 text-center">Category Name</th>

            </tr>
            <tr>
              <td>
                   <select name="parent_id" class="form-control">
                       <option value="0" >Select Parent</option>
                       <?php
                         $query = mysqli_query($con,"select * from category");
                         $arr=mysqli_fetch_all($query);
                         foreach($arr as $cat)
                         {
                          ?>
                            <option value="<?=$cat[0]?>"> <?php echo $cat[1]; ?> </option>
                          <?php
                         }
                       ?>

                   </select>
               </td>
              <td class="py-2"> <input type="text" name="name" value="" class="form-control" placeholder="Category Name"> </td>
            </tr>
            <tr>
               <th colspan="2" class="py-2 text-center"> <input type="submit" name="submit" class="btn btn-success" value="save"> </th> 
           </tr>
        </table>
    </form>
    
    <hr><hr>
    
    <?php
$query=mysqli_query($con,"select * from category where parent_id='0'");
$arr=mysqli_fetch_all($query);
echo '<ol>';
foreach($arr as $val)
{
  ?>
   <li> <?php echo $val[1]; ?>
        <?php  echo getChild($con,$val[0]);  ?>
   </li>
  <?php
    
}
echo '</ol>';


function getChild($con,$id)
{
    $query = mysqli_query($con,"select *  from category where parent_id='$id'"); //for get child
    $rows=mysqli_num_rows($query);
    if($rows > 0) // child present
    {
        $childs=mysqli_fetch_all($query);
        echo '<ol>';
        foreach($childs as $child)
        {
         echo '<li>'.$child[1].'</li>';
            getChild($con,$child[0]);
        }
        echo '</ol>';
    }
    else // child  not present
    {
        return false;
    }
}

?>
    
    
</body>    
</html>