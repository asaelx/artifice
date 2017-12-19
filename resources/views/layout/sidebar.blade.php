<aside class="sidebar">
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            @if (isset($settings->sidebar_logo->url))
                <img src="{{ asset('storage/'.$settings->sidebar_logo->url) }}" alt="{{ $settings->title }}" class="img">
            @else
                <img src="{{ asset('img/logo.png') }}" alt="{{ $settings->title }}" class="img">
            @endif
        </a>
        <!-- /.logo -->
        <h2 class="title">{{ $settings->title }}</h2>
        <!-- /.title -->
    </header>
    <!-- /.header -->
    @php
        $options = [
            '/' => ['icon' => 'home', 'name' => 'Inicio'],
            'cotizaciones' => ['icon' => 'clipboard', 'name' => 'Cotizaciones'],
            'clientes' => ['icon' => 'group', 'name' => 'Clientes'],
            'productos' => ['icon' => 'th-list', 'name' => 'Productos'],
            'marcas' => ['icon' => 'tags', 'name' => 'Marcas'],
            'categorias' => ['icon' => 'tags', 'name' => 'Categorías'],
            'reportes' => ['icon' => 'chart-pie', 'name' => 'Reportes'],
            'emails' => ['icon' => 'mail', 'name' => 'Emails enviados']
        ];

        $admin_options = [
            'monedas' => ['icon' => 'database', 'name' => 'Monedas'],
            'usuarios' => ['icon' => 'user', 'name' => 'Usuarios'],
            'ajustes' => ['icon' => 'cog-outline', 'name' => 'Ajustes']
        ];

        if(Auth::user()->role == 'admin')
            $options = array_merge($options, $admin_options);
    @endphp
    <nav class="nav">
        <ul class="list">
            @foreach ($options as $url => $info)
                <li class="item {{ (Request::is($url) || Request::is($url.'/*') ? 'active' : '') }}">
                    <a href="{{ url($url) }}" class="link"><i class="typcn typcn-{{ $info['icon'] }}"></i> {{ $info['name'] }}</a>
                </li>
                <!-- /.item -->
            @endforeach
            <li class="item">
                {{ Form::open(['url' => url('logout')]) }}
                    <button type="submit" class="link"><i class="typcn typcn-eject"></i> Cerrar sesión</button>
                {{ Form::close() }}
            </li>
            <!-- /.item -->
        </ul>
        <!-- /.menu -->
    </nav>
    <!-- /.nav -->
</aside>
<!-- /.sidebar -->
