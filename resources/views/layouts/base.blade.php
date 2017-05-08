<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>bChat</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet" />
  </head>

  <body style="font-family:Verdana">
    <div class="container">
      <div class="row " style="padding-top:40px;">
      <h3 class="text-center" ><a href="/"><button class="btn btn-success">Home</button></a></h3>
      <h3 class="text-center" >
        <form action="/logout" method="POST">
          <button class="btn btn-danger" type="submit">Logout</button>
          {{ csrf_field() }}
        </form>
      </h3>
      
      @yield('header')    
      <br/><br/>

      @yield('content')

      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.slim.min.js"></script>  
      <script src="/js/jquery-3.2.1.min.js"></script>
      @include('js.mainJs')
      @yield('js')
  </body>
</html>
