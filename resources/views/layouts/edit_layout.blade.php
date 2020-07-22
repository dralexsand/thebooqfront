<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'TheBooq.Edit') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>
    
    <link type="text/css" rel="stylesheet" href="{{ asset('jodit/build/jodit.min.css') }}"/>
    <script type="text/javascript" src="{{ asset('jodit/build/jodit.min.js') }}"></script>
    
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
<div id="app">
    
    {{--@include('layouts.parts.navbartailwind')--}}
    @include('layouts.parts.dropdown_slide')
    
    <main class="py-4">
        @yield('content')
    </main>
</div>



<script>
  
  $(function () {
  
    /*$('#editor_content').each(function () {
      var editor = new Jodit(this);
      editor.value = '<p>start</p>';
    });*/
  
    var editor = new Jodit('#editor_content', {
      uploader: {
        url: 'http://thebooqfrontlara.prod/upload'
      },
      filebrowser: {
        ajax: {
          url: 'http://thebooqfrontlara.prod/ajaxFileUpload'
        }
      }
    });
    
  });

</script>

</body>
</html>
