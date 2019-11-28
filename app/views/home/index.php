<?php $this->setLayout('global_layout');?>
<?php $this->setSiteTitle('Home');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>


<?php $this->start('body'); ?>
    <!-- main container starts -->
    <!-- search box conatainer -->
    <div class="search-bigbox">
        <div class="bg_img"><img src="/img/bg.jpg" alt=""></div>
        <div class="search-container">
            <div class="search-content">
                <!-- <img src="/img/svinay2.png" alt=""> -->
                <div class="search-header">SEARCH JOBS, COLLEGES, EXAMS...</div>
                <form action="/search" method="get">
                    <input type="text" name="q" class="search-input-big" id="searchbox-big">
                    <i class="fa fa-search search-icon-big"></i>
                    <div class="search-result-list">
                        <a href="#">
                            <div>Search Result 1</div>
                            <span>This is search description</span>
                        </a>
                        <a href="#">
                            <div>Another Search Result</div>
                            <span>Another description description</span>
                        </a>
                    </div>
                    <input type="submit" class="search-btn-big" value="Search">
                </form>
            </div>
        </div>
    </div>

    <div class="tBigBox">
        <div class="tBigBoxTabs">
            <button>ENGINEERING JOBS</button>
            <button>MEDICAL JOBS</button>
            <button>SARKARI JOBS</button>
            <button>MARGINAL JOBS</button>
            <button>SECRET JOBS</button>
        </div>
        <div class="tBigBoxContents">
            Tab Contents 1
        </div>
        <div class="tBigBoxContents">
            Tab Contents 2
        </div>
        <div class="tBigBoxContents">
            Tab Contents 3
        </div>
        <div class="tBigBoxContents">
            Tab Contents 4
        </div>
        <div class="tBigBoxContents">
            Tab Contents 5
        </div>
    </div>

    <div class="dBigBox">
        <table>
            <tbody>
                <tr>
                    <th>HEAD 1</th>
                    <th>HEAD 2</th>
                </tr>

                <tr>
                    <td><a href="#">This is a news</a></td>
                    <td><a href="#">This is another news</a></td>
                </tr>

                <tr>
                    <td><a href="#">This is a news</a></td>
                    <td><a href="#">This is another news</a></td>
                </tr>

                <tr>
                    <td><a href="#">This is a news</a></td>
                    <td><a href="#">This is another news</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- main container ends -->
<?php $this->end(); ?>