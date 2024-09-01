<div>
    <button wire:click="openMenu()" type="button" class="menu-button">
        <i class="fa-solid fa-bars fa-2xl" style="color: #ffffff;"></i>
    </button>

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
            <a class="menu-modal__link" href="">Home</a>
            <a class="menu-modal__link" href="/register">Registration</a>
            <a class="menu-modal__link" href="/login">Login</a>
            @endguest
            @auth
            <a class="menu-modal__link" href="">Home</a>
            <a class="menu-modal__link" href="">Logout</a>
            <a class="menu-modal__link" href="">Mypage</a>
            @endauth
        </div>
    </div>
    @endif
</div>