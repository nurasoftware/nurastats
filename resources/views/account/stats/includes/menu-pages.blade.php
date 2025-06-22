<nav class="nav nav-tabs mb-2" id="myTab" role="tablist">
    <a class="nav-item nav-link @if (($active_tab ?? null) == 'pages') active @endif" href="{{ route('site.pages', ['code' => $site->code]) }}"><i class="bi bi-gear"></i> {{ __('Pages') }}</a>    
</nav>
