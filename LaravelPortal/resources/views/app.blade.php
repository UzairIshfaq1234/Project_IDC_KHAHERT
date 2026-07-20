<!DOCTYPE html>
<html lang="en" data-theme="light">

@include('layouts.header')

<body class="@yield('bodyclass')">

    @yield('content')

    @include('layouts.footer')

    @stack('scripts')
</body>

</html>
