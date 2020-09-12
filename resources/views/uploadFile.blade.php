<html>
   <body>
      <form action="/uploadfile" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         Please instert CSV file:
         <br />
         <input type="file" name="csv" />
         <br /><br />
         <input type="submit" value=" Save " />
     </form>
   </body>
</html>