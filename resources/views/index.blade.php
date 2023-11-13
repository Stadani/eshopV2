<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EShop | Main Page</title>


    @extends('components/layout')

</head>

<body>
<!--HEADER & NAVBAR-->
    <header>
        <div class="head">
            <div class="header_content">
                <img src="/images/bruh.png" alt="logo">
                GAMESHOP
            </div>
        </div>

        <div class="navbar" >
            <div class="navbar_center">
                <div class="navabar_main">
                    <a href="/" class="nav_button">Home</a>
                    <a href="list" class="nav_button">Games</a>
                    <a href="forum" class="nav_button">Discussion</a>
                </div>

                <div class="sidenav links">
                    <a class="nav_button"><i class="fa-solid fa-key"></i> Log In</a>
                    <a class="nav_button"><i class="fa-solid fa-pencil"></i> Sign In</a>
                </div>

                <div class="navbar_tgl_button">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </div>

        <x-dropdownNavbar>

        </x-dropdownNavbar>
    </header>

<!--CAROUSEL-->
<x-carousel>

</x-carousel>

<!--MAIN-->
    <div class="main_content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis molestie elit, a luctus mi. Nunc tempor ornare fringilla. Sed sit amet tellus sed sapien pretium varius. Integer non tempor massa. Suspendisse egestas auctor turpis. Curabitur pulvinar consequat fringilla. Maecenas faucibus tincidunt erat, non condimentum turpis mattis sit amet. Curabitur nibh mauris, tincidunt ut volutpat quis, tristique nec nulla. Pellentesque vulputate ultrices facilisis. Quisque pretium leo sed purus ultricies, vitae pretium lacus finibus. Sed elementum mi nibh, ac dictum arcu sagittis a. Donec iaculis maximus eros. Suspendisse potenti. In vulputate libero sit amet tortor egestas, eu maximus lectus dapibus.
    </div>

<!--FOOTER-->
    <footer>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-clipboard"></i> About Us</p>
           Gameshop is shop and forum at the same time.
           Users can buy, rate, comment and discuss videogames.
       </div>
       <div class="footer_content_block">
           <p><i class="fa-regular fa-envelope"></i> Contact</p>
            E-mail: stadani2@stud.uniza.sk
       </div>
       <div class="footer_content_block">
           <p><i class="fa-solid fa-chart-line"></i> Statistics</p>
       </div>
    </footer>

</body>
</html>
