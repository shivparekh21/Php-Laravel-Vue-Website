<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    </head>
    <body class="antialiased">
       <div id="app">
           <router-view>

           </router-view>
       </div>
    </body>
<script src="{{mix('/js/app.js')}}"></script>
</html>
