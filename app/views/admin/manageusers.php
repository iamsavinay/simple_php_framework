<?php $this->setLayout('admin_layout');?>
<?php $this->setSiteTitle('Manage Users');?>

<?php $this->start('head'); ?>
<meta content="some/meta" />
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title"> Select User to Change</h1>

<div class="global-content">
    <div class="main-content">
        <div class="tool-cont">
            <form id="search" method="get">
                <div>
                    <!-- DIV needed for valid HTML -->
                    <label for="searchbar"><img src="/static/admin/img/search.svg" alt="Search"></label>
                    <input type="text" size="40" name="q" value="" id="searchbar" autofocus="">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
        <div class="content">
            <?php if(!empty($this->userdata)) : ?>
            <table>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Perms</th>
                </tr>
                <?php foreach($this->userdata as $user) : 
                        $role = '';
                        $perm = '';
                        if(!empty($user->roles)) {
                            $roles = json_decode($user->roles);
                            $role = '';
                            foreach ($roles as $key) {
                                $role .= '<a href="'.PROOT.'admin/roles/'.$key.'" class="role">'.$key.'</a>';
                            }
                        }
                        if(!empty($user->perms)) {
                            $perms = json_decode($user->perms);
                            $perm = '';
                            foreach ($perms as $key) {
                                $perm .= '<span class="perm">'.$key.'</span>';
                            }
                        }
                    ?>
                <tr>
                    <td>
                        <a href="<?=PROOT?>admin/user/<?=$user->id?>/change"><?=$user->username?></a>
                    </td>
                    <td>
                        <?=$user->fname?>
                    </td>
                    <td>
                        <?=$user->lname?>
                    </td>
                    <td>
                        <?=$user->email?>
                    </td>
                    <td>
                        <?=$role?>
                    </td>
                    <td>
                        <?=$perm?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="tool-cont">
                <?php 
                    $totalpages = (($this->usercount%20) == 0) ? (int)$this->usercount/20 : (int)($this->usercount/20)+1;
                    $page = $this->pageindex;

                    if($page-1 > 1) {
                        echo '<a href="'.PROOT.'adming/user?q='.$this->query.'&p='.($page-1).'">PREV</a>';
                        echo '<span class="separator">|</span>';
                    }
                    
                    if ($totalpages>$page) {
                        echo '<a href="'.PROOT.'adming/user?q='.$this->query.'&p='.($page+1).'">NEXT</a>';
                        echo '<span class="separator">|</span>';
                    }
                    echo '<span> Page '.$page.' of '.$totalpages.' </span>';
                    echo '<span class="separator">|</span>';
                    echo '<span> Results : '.count($this->userdata).' </span>';
                    echo '<span class="separator">|</span>';
                    echo '<span> Total Users: '.$this->usercount.' </span>';
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

<?php $this->end(); ?>