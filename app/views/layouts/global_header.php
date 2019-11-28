<?php
$menu = Router::getMenu("topnav_menu");
$currentPage = Helper::currentPage();
$topnav = $menu['topnav'];
$sidenav = $menu['sidenav'];
$user = Helper::currentUser();
?>


<!-- new code  -->

<div class="tn1">
    <div class="tn1-contents">
        <div id="menu-icon" class="menu-icon">
            <div>
                <div class="hamburger-btn"><i></i><i></i><i></i></div>
            </div>
        </div>
        <div class="site-logo"><a href="/"><img src="<?=LOGO_WIDE?>" alt="LOGO"></a></div>
        <div class="left-links">
            <?php
                foreach($topnav as $key => $value){
                    echo '<a href="'.$value.'"><div class="text">'.$key.'</div></a>';
                }
            ?>
        </div>
        <div class="right-links">
            <div id="topnav-search" class="topnav-search">
                <div><input type="text" name="search" id="search-box"><i class="fa fa-search" aria-hidden="true"></i></div>
            </div>
            <div class="link-container">
                <a href="#"><span>
                        <?php
                        if($user){
                            echo $user->fname;
                        } else {
                            echo 'SignIn/SignUp';
                        }
                    ?>
                    </span></a>
                <div class="link-contents">
                    <?php if($user): ?>
                    <div class="user-detail">
                        <div class="img"><img src="<?=PIROOT.$user->picture?>" alt=""></div>
                        <div class="name"><span>Savinay Kumar</span></div>
                    </div>
                    <div class="actions">
                        <a href="/user/dashboard" class="btn btnLightBlue btnBorder">Dashboard</a>
                        <a href="/user/logout" class="btn btnBlueGreen btnBorder">SignOut</a>
                    </div>
                    <?php else: ?>
                    <div class="user-detail">
                        <div class="img"><img src="<?=DEFAULT_USER_IMG?>" alt=""></div>
                        <div class="name"><span>Please login ...</span></div>
                    </div>
                    <div class="actions">
                        <a href="/user/register" class="btn btnLightBlue btnBorder">SignUp</a>
                        <a href="/user/login" class="btn btnBlueGreen btnBorder">SignIn</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tn2">
    <div class="tn2-contents">
        <div class="center-links">
            <div aria-haspopup="true" class="link-container">
                <a href="#" aria-haspopup="true"><span> ENGINEERING<i class="fa fa-angle-up"></i></span></a>
                <div class="submenu" aria-label="submenu">
                    <div class="submenu-content">
                        <div class="sub-links">
                            <a href="#">Government <i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents1.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Private<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents2.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Others<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents3.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-haspopup="true" class="link-container">
                <a href="#" aria-haspopup="true"><span>MEDICAL<i class="fa fa-angle-up"></i></span></a>
                <div class="submenu" aria-label="submenu">
                    <div class="submenu-content">
                        <div class="sub-links">
                            <a href="#">Government <i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents1.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Private<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents2.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Others<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents3.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-haspopup="true" class="link-container">
                <a href="#" aria-haspopup="true"><span>COMMERCE<i class="fa fa-angle-up"></i></span></a>
                <div class="submenu" aria-label="submenu">
                    <div class="submenu-content">
                        <div class="sub-links">
                            <a href="#">Government <i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents1.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Private<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents2.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Others<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents3.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-haspopup="true" class="link-container">
                <a href="#" aria-haspopup="true"><span> ENGINEERING<i class="fa fa-angle-up"></i></span></a>
                <div class="submenu" aria-label="submenu">
                    <div class="submenu-content">
                        <div class="sub-links">
                            <a href="#">Government <i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents1.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Private<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents2.
                            </div>
                        </div>
                        <div class="sub-links">
                            <a href="#">Others<i class="fa fa-angle-right"></i></a>
                            <div class="link-contents">
                                This is link contents3.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- sidenav -->

<div id="sidenav" class="sidenav">
    <div class="sidenav-content">
        <div class="user-info">
            <?php if($user): ?>
            <div class="profile-pic">
                <img src="<?=PIROOT.$user->picture?>" alt="">
            </div>
            <div class="profile-actions">
                <a href="/user/dashboard" class="btn btnLightBlue btnBorder">Dashboard</a>
                <a href="/user/logout" class="btn btnBlueGreen btnBorder">SignOut</a>
            </div>
            <?php else: ?>
            <div class="profile-pic">
                <img src="<?=DEFAULT_USER_IMG?>" alt="">
            </div>
            <div class="profile-actions">
                <a href="/user/register" class="btn btnLightBlue btnBorder">SignUp</a>
                <a href="/user/login" class="btn btnBlueGreen btnBorder">SignIn</a>
            </div>
            <?php endif; ?>
        </div>
        <div class="link-container">
            <?php
                foreach($sidenav as $key => $value){
                    if(is_array($value)){
                        echo '<button class="sidenav-submenu-btn">'.$key.'<i class="fa fa-angle-down"></i></button>';
                        echo '<div class="sidenav-submenu-content">';
                        foreach($value as $k => $v){
                            echo '<a href="'.$v.'">'.$k.'</a>';
                        }
                        echo '</div>';
                    } else {
                        echo '<a href="'.$value.'">'.$key.'</a>';
                    }
                }
            ?>
        </div>
    </div>
</div>

<!-- search-modal -->

<div id="search-overlay" class="search-overlay">
    <div class="search-content">
        <form action="/search" method="get" onsubmit="return false" role="Search">
            <div class="search-input-cont">
                <input type="text" name="q" id="so-input">
                <button class="so-btn"><i class="fa fa-search"></i></button>
            </div>
            <div class="search-other-cont">
                <div id="close-so-btn" class="hamburger-btn active"><i></i><i></i><i></i></div>
            </div>
        </form>
    </div>
</div>