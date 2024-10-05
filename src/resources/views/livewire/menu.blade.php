<div class="header__inner--left">
    <button wire:click="openMenu()" type="button" class="menu-button">
        <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff;"></i>
    </button>
    <h1 class="header__logo">Rese</h1>

    @if($showMenu)
    <div class="menu-modal">
        <div class="menu-modal--button__outer">
            <div class="menu-modal--button__inner">
                <button wire:click="closeMenu()" type="button" class="menu-button">
                    <i class="fa-solid fa-xmark fa-2xl" style="color: #ffffff;"></i>
                </button>
            </div>
        </div>
        <div class="menu-modal__inner">
            @guest
            <a class="menu-modal__link" href="/">Home</a>
            <a class="menu-modal__link" href="/register">Registration</a>
            <a class="menu-modal__link" href="/login">Login</a>
            @endguest
            @auth
            <a class="menu-modal__link" href="/">Home</a>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="menu-modal__link" type="submit">Logout</button>
            </form>
            <a class="menu-modal__link" href="/mypage">Mypage</a>
            @endauth
        </div>
    </div>
    @endif
</div>