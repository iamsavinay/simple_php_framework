

<div class="footer">
    <div class="footer-contents">
        <div class="footer-col-cont">
            <div class="footer-col">
                <div class="footer-site-image">
                    <img src="<?=LOGO_WIDE?>" alt="">
                </div>
                <div class="footer-site-title">
                    College Talash Edu Services Pvt. Ltd.
                </div>
                <div class="footer-site-desc">
                    This is an educational website.
                    And We are working to provide you
                    all types of study guidance all the courses
                    aroud the globe.
                </div>
            </div>
            <div class="footer-col">
                <div class="footer-head">
                    News
                </div>
                <div class="footer-content">
                    <a href="#">This exam key released</a>
                    <a href="#">No one knows what is this</a>
                    <a href="#">Don't Blame me</a>
                    <a href="#">This exam key released.</a>
                </div>
            </div>
            <div class="footer-col">
                <div class="footer-head">
                    Courses
                </div>
                <div class="footer-content">
                    <a href="#">This exam key released</a>
                    <a href="#">No one knows what is this</a>
                    <a href="#">Don't Blame me</a>
                    <a href="#">This exam key released.</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-foo">
        Copyright &copy; College Talash 2019. All Rights Reserved
    </div>
</div>

<script>
        // menu btn click function
        document.querySelector('#menu-icon').addEventListener('click', toggleSidenav);

        function toggleSidenav() {
            var sidenav = document.querySelector('#sidenav');
            if (!sidenav.classList.contains('active')) {
                document.querySelector('#menu-icon .hamburger-btn').classList.add('active');
                sidenav.classList.add('active');
                setTimeout(function () {
                    document.addEventListener("click", outSide, false);
                }, 100);
            } else {
                document.querySelector('#menu-icon .hamburger-btn').classList.remove('active');
                sidenav.classList.remove('active');
                document.removeEventListener("click", outSide, false);
            }
        }

        function outSide(event) {
            if (event.target.closest('#sidenav') == null) {
                toggleSidenav();
            }
        }

        //sidenav submenu 
        var snmenu = document.querySelectorAll('.sidenav-submenu-btn');
        if(snmenu){
            snmenu.forEach(el => {
                el.addEventListener('click', function(event){
                    var nextDiv = event.target.nextElementSibling;
                    event.target.classList.toggle('active');
                    nextDiv.classList.toggle('active');
                });
            });
        }
    </script>
    <script>
        // submenu 2 tabs control
        var tn2 = document.querySelector('.tn2')
        var submenucontent = tn2.querySelectorAll('.submenu-content');
        submenucontent.forEach(element => {
            var sublinks = element.querySelectorAll('.sub-links');
            sublinks[0].classList.add('active');
            sublinks.forEach(el => {
                el.addEventListener('mouseenter', function (event) {
                    sublinks.forEach(e => {
                        e.classList.remove('active');
                    });
                    event.target.classList.add('active');
                });

            });

        });
    </script>
    <script>
        var topnav1 = document.querySelector('.tn1');
        var topnav2 = document.querySelector('.tn2');
        window.addEventListener('scroll', function () {
            // console.log("scrolled");
            tthrottle(shrinkTopnav, 200);

        });

        function throttle(fn, wait) {
            var time = Date.now();
            return function () {
                if ((time + wait - Date.now()) < 0) {
                    setTimeout(function () {
                        fn();
                    }, 100);
                    time = Date.now();
                }
            }
        }

        var stimeout;

        function tthrottle(fn, wait) {
            clearTimeout(stimeout);
            stimeout = setTimeout(function () {
                console.log('scrolled');
                fn();
            }, wait);
        }

        function shrinkTopnav() {
            // console.log(window.pageYOffset);
            if (window.pageYOffset > 100) {
                topnav1.classList.add('shrinked');
                topnav2.classList.add('shrinked');
            } else {
                topnav1.classList.remove('shrinked');
                topnav2.classList.remove('shrinked');
            }
        }
    </script>
    <script>
        document.querySelectorAll('.tBigBox').forEach(el => {
            el.querySelectorAll('.tBigBoxTabs button').forEach(elem => {
                elem.addEventListener('click', function (event) {
                    var par = event.target.parentElement;
                    var index = Array.from(par.children).indexOf(event.target);
                    Array.from(par.children).forEach(e => {
                        e.classList.remove('active');
                    });
                    par.children[index].classList.add('active');
                    var contents = par.parentElement.querySelectorAll('.tBigBoxContents');
                    contents.forEach(e => {
                        e.classList.remove('active');
                    });
                    contents[index].classList.add('active');
                });
            });
            el.querySelector(".tBigBoxTabs button").click();
        });
    </script>
    <script>
        var so = document.querySelector('#search-overlay');
        var si = document.querySelector('#search-box');
        var soi = document.querySelector('#so-input');
        document.querySelector('#topnav-search').addEventListener('click', function(event){
            so.classList.add('active');
            var si_value = si.value;
            if(si_value != ''){
                soi.value = si_value;
                si.value = '';
            }
            soi.focus();
        });

        document.querySelector('#close-so-btn').addEventListener('click', function(){
            so.classList.remove('active');
        })
    </script>