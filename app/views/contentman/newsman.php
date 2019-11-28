<?php $this->setLayout('contentman_layout');?>
<?php $this->setSiteTitle('Manage News');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">News</h1>

<div class="global-content">
    <div class="main-content">
        <div class="tool-cont">
            <form id="search" method="get">
                <div>
                    <!-- DIV needed for valid HTML -->
                    <label for="searchbar"><img src="/static/admin/img/search.svg" alt="Search"></label>
                    <input type="text" size="40" name="q" value="<?=$this->query?>" id="searchbar" autofocus="">
                    <input type="submit" value="Search">
                    <select name="l" id="searchlimit">
                        <?php 
                            foreach ([5, 10, 20, 30, 50] as $key) {
                                if($key == $this->fetchlimit) {
                                    echo '<option value="'.$key.'" selected>'.$key.'</option>';
                                } else {
                                    echo '<option value="'.$key.'" >'.$key.'</option>';
                                }
                            }
                        ?>

                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>

                    <?php
                        if($this->query != '') {
                            echo '<span>Matches Found: <b>'.$this->matchedresults.'</b></span>';
                        }

                    ?>
                </div>
            </form>
            <a href="#" class="btn btn-blue" id="add-btn">Add News</a>
        </div>
        <div class="content">
            <?php if(!empty($this->resultdata)) : ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Modified</th>
                    <th>Comments</th>
                </tr>
                <?php foreach($this->resultdata as $news) : ?>
                <tr>
                    <td><a href="<?=PROOT?>contentman/news/<?=$news->id?>/edit">
                            <?=$news->title?></a></td>
                    <td>
                        <?=$news->tags?>
                    </td>
                    <td>
                        <?=$news->status?>
                    </td>
                    <td>
                        <?=$news->published?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="tool-cont">
                <!-- bottom tools -->
                <?php 

                    if($this->query != '') {
                        $totalpages = ($this->matchedresults%$this->fetchlimit == 0) ? (int)$this->matchedresults/$this->fetchlimit : (int)($this->matchedresults/$this->fetchlimit)+1;
                    } else {
                        $totalpages = ($this->totalresults%$this->fetchlimit == 0) ? (int)$this->totalresults/$this->fetchlimit : (int)($this->totalresults/$this->fetchlimit)+1;
                    }

                    $page = $this->pageindex;

                    if($page-1 >= 1) {
                        echo '<a href="'.PROOT.'contentman/news?q='.$this->query.'&p='.($page-1).'&l='.$this->fetchlimit.'">PREV</a>';
                        echo '<span class="separator">|</span>';
                    }
                    
                    if ($totalpages>$page) {
                        echo '<a href="'.PROOT.'contentman/news?q='.$this->query.'&p='.($page+1).'&l='.$this->fetchlimit.'">NEXT</a>';
                        echo '<span class="separator">|</span>';
                    }
                    echo '<span> Page '.$page.' of '.$totalpages.' </span>';
                    if($this->query != '') {
                        echo '<span class="separator">|</span>';
                        echo '<span> Mached News : '.$this->matchedresults.' </span>';
                    }
                    echo '<span class="separator">|</span>';
                    echo '<span> Total News: '.$this->totalresults.' </span>';
                ?>
            </div>
            <?php else : ?>
            <div class="message">No Data Found</div>
            <?php endif; ?>
        </div>
    </div>


    <div class="related-content">
        <div class="card1">

        </div>
    </div>
</div>

<div id="add-news" data-toggle="modal" class="modal" tabindex="-1">
    <div class="modal-dialog-wrap">
        <div class="modal-dialog">
            <div class="modal-header">
                Add News Article
                <div class="hamburger-btn active">
                    <i></i><i></i><i></i>
                </div>
            </div>
            <div class="modal-body">
                <!-- news add form -->
                <form id="add-news-form" action="" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="alias">Permalink</label>
                        <input type="text" name="alias" id="alias">
                    </div>
                    <div class="form-group"><div class="modal-error-msg" id="add-news-error"></div></div>
                    <div class="form-group">
                    <input type="submit" id="add-news-submit" class="btn btn-blue float-right" value="Submit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                This is modal footer.
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>

<?php $this->start('script') ?>

<script src="<?=PROOT?>js/jquery.js"></script>

<script type="text/javascript">
    $('.hamburger-btn').click(function () {
        $(this).removeClass('active');
        $('#add-news').removeClass("active");
    });

    $('#add-btn').click(function () {
        $('.hamburger-btn').addClass('active');
        $('#add-news').addClass("active");
    });

    $('#add-news-submit').click(function (e) { 
        e.preventDefault();

        $form = $("add-news-form");

        $title = $('#title').val();
        console.log($title);
        
        $alias = $('#alias').val();
        console.log($alias);
        
        $.ajax({
            type: "post",
            url: "news/add",
            data: {
                action: "add",
                title: $title,
                alias: $alias
            },
            datatype: 'json',
            success: function (r) {
                if(r.status == 'success') {
                    console.log(r.id);
                    $('#add-news-error').html(r.message);
                    window.location.href = 'news/'+r.id+'/edit';
                } else {
                    $('#add-news-error').html(r.message);
                }
                
            }
        });
        
    });
</script>

<?php $this->end()?>