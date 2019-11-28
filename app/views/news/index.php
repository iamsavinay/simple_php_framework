<?php $this->setLayout('global_layout');?>
<?php $this->setSiteTitle('College Talash News | Get important educational news updates on your fingertips');?>

<?php $this->start('head'); ?>

<link rel="stylesheet" href="<?=PROOT.'css/theme1landing.css'?>">

<?php $this->end(); ?>


<?php $this->start('body'); ?>

<div class="ws-cnt">
    <div class="bg_img"><img src="/img/geometric.jpg" alt=""></div>
    <div class="ws-content">
        <h3>Search News, Articles, Blog</h3>
        <form id="ws-form" action="<?=PROOT?>search" method="get">
            <input type="hidden" name="f" value="news">
            <input type="text" name="q" id="ws-input">
            <button id="ws-submit">Search</button>
        </form>
    </div>
    <script>
        document.querySelector('#ws-submit').addEventListener('click', function (event) {
            event.preventDefault();
            if (document.querySelector('#ws-input').value != '') {
                console.log(document.querySelector('#ws-input').value);
                document.querySelector('#ws-form').submit();
            }
        });
    </script>
</div>

<div class="sc-cont">
    <div class="sc-head">This is some content</div>
    <div class="sc-body">
        <div class="sc-card">
            <a href="#">
                <img src="/img/geometric.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/default_user.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/books.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="sc-foot">
        <button class="more-btn">Load More...</button>
    </div>
</div>

<div class="sc-cont">
    <div class="sc-head">This is some content</div>
    <div class="sc-body">
        <div class="sc-card">
            <a href="#">
                <img src="/img/geometric.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/default_user.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/books.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="sc-foot">
        <button class="more-btn">Load More...</button>
    </div>
</div>

<div class="sc-cont">
    <div class="sc-head">This is some content</div>
    <div class="sc-body">
        <div class="sc-card">
            <a href="#">
                <img src="/img/geometric.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/default_user.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/books.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="sc-foot">
        <button class="more-btn">Load More...</button>
    </div>
</div>

<div class="sc-cont">
    <div class="sc-head">This is some content</div>
    <div class="sc-body">
        <div class="sc-card">
            <a href="#">
                <img src="/img/geometric.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/default_user.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
        <div class="sc-card">
            <a href="#">
                <img src="/img/books.jpg" alt="">
                <div>
                    <h4 class="sc-title">This is title</h4>
                    <p class="sc-desc">This is a description of the above title
                        don't worry we will fix that without worries.
                    </p>
                </div>
            </a>
        </div>
    </div>
    <div class="sc-foot">
        <button class="more-btn">Load More...</button>
    </div>
</div>



<?php $this->end(); ?>