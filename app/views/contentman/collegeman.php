<?php 
use function GuzzleHttp\json_decode;
$this->setLayout('contentman_layout');?>
<?php $this->setSiteTitle('Manage College');?>

<?php $this->start('head'); ?>

<meta content="some/meta" />
<link rel="stylesheet" href="<?=PROOT?>css/select2.css">


<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">College</h1>

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
            <button class="btn btn-blue" id="add-btn">Add College</button>
        </div>
        <div class="content">
            <?php if(!empty($this->resultdata)) : ?>
            <table>
                <tr>
                    <th>College</th>
                    <th>Address</th>
                    <th>Parent</th>
                    <th>Published</th>
                    <th>Modified</th>
                </tr>
                <?php foreach($this->resultdata as $college) : ?>
                <tr>
                    <td>
                        <span class=""><a href="<?=PROOT?>contentman/college/<?=$college->id?>/edit"><?=$college->name?></a></span>
                        <?php 
                            if($college->aka){
                                $aka = json_decode($college->aka);
                                foreach ($aka as $key) {
                                    echo '<span>'.$key.'</span>';
                                }
                            }
                        ?>
                    </td>
                    <td><?=$college->city.', '.$college->state?></td>
                    <td>
                        <select name="parent" class="parent-select" data-id="<?=$college->id?>" id="parent">
                            <?php
                                if($college->parent) {
                                    echo '<option value="'.$college->parent.'" selected>'.$college->parent.'</option>';
                                } else {
                                    echo '<option value="0" selected>0</option>';
                                }
                            ?>
                        </select>
                    </td>
                    <td><?=$college->published_date.' by '.$college->published_by?></td>
                    <td><?=$college->modified_date.' by '.$college->modified_by?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="tool-cont">
                <!-- the bottom tool -->
                <?php 

                    if($this->query != '') {
                        $totalpages = ($this->matchedresults%$this->fetchlimit == 0) ? (int)$this->matchedresults/$this->fetchlimit : (int)($this->matchedresults/$this->fetchlimit)+1;
                    } else {
                        $totalpages = ($this->totalresults%$this->fetchlimit == 0) ? (int)$this->totalresults/$this->fetchlimit : (int)($this->totalresults/$this->fetchlimit)+1;
                    }

                    $page = $this->pageindex;

                    if($page-1 >= 1) {
                        echo '<a href="'.PROOT.'contentman/college?q='.$this->query.'&p='.($page-1).'&l='.$this->fetchlimit.'">PREV</a>';
                        echo '<span class="separator">|</span>';
                    }
                    if ($totalpages>$page) {
                        echo '<a href="'.PROOT.'contentman/college?q='.$this->query.'&p='.($page+1).'&l='.$this->fetchlimit.'">NEXT</a>';
                        echo '<span class="separator">|</span>';
                    }
                    echo '<span> Page '.$page.' of '.$totalpages.' </span>';
                    if($this->query != '') {
                        echo '<span class="separator">|</span>';
                        echo '<span> Mached College : '.$this->matchedresults.' </span>';
                    }
                    echo '<span class="separator">|</span>';
                    echo '<span> Total College: '.$this->totalresults.' </span>';
                    echo '<span><form style="display:inline-block;width:auto" method="get" action="">Goto Page:</span><input name="p" id="gotopage" type="number" max="'.$totalpages.'">';
                    echo '<input type="submit" value="Go">'
                    .'<input type="hidden" name="q" value="'.$this->query.'">'
                    .'<input type="hidden" name="l" value="'.$this->fetchlimit.'">'
                    .'</form>';
                ?>
            </div>
            <?php else : ?>
            <div class="message">No Data Found</div>
            <?php endif; ?>
        </div>
    </div>


    <div class="related-content">
    <div class="card card1">
            <label for="cdinput">College Dunia</label><br>
            <input type="text" name="cdinput" id="cdinput">
            <div id="cdclg">
                Type to search
            </div>
        </div>
        <div class="card card2">
        <label for="cpinput">CollegePravesh</label><br>
            <input type="text" name="cpinput" id="cpinput">
            <div id="cpclg">
                Type to search
            </div>
        </div>
        
    </div>
</div>

<div id="add-college" data-toggle="modal" class="modal" tabindex="-1">
    <div class="modal-dialog-wrap">
        <div class="modal-dialog">
            <div class="modal-header">
                Add College
                <div class="hamburger-btn active">
                    <i></i><i></i><i></i>
                </div>
            </div>
            <div class="modal-body">
                <!-- college add form -->
                <form id="add-college-form" action="" method="post">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="alias">Alias</label>
                        <input type="text" name="alias" id="alias">
                    </div>
                    <div class="form-group"><div class="modal-error-msg" id="add-college-error"></div></div>
                    <div class="form-group">
                    <input type="submit" id="add-college-submit" class="btn btn-blue float-right" value="Submit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                Make sure that alias is unique!
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>

<?php $this->start('script'); ?>

<script src="<?=PROOT?>js/jquery.js"></script>

<script>
    $('.hamburger-btn').click(function () {
        $(this).removeClass('active');
        $('#add-college').removeClass("active");
    });

    $('#add-btn').click(function () {
        $('.hamburger-btn').addClass('active');
        $('#add-college').addClass("active");
    });

    $('#add-college-submit').click(function (e) { 
        e.preventDefault();

        $form = $("add-college-form");

        $name = $('#name').val();
        console.log($name);
        
        $alias = $('#alias').val();
        console.log($alias);
        
        $.ajax({
            type: "post",
            url: "college/add",
            data: {
                action: "add",
                name: $name,
                alias: $alias
            },
            datatype: 'json',
            success: function (r) {
                if(r.status == 'success') {
                    console.log(r.id);
                    $('#add-college-error').html(r.message);
                    // window.location.href = 'news/'+r.id+'/edit';
                } else {
                    $('#add-college-error').html(r.message);
                }
                
            }
        });
        
    });


    $("#name").on('keyup', function() {
        $val = $(this).val().replace(/\s/g,'-');
        console.log($val);
        $("#alias").val($val);
    });





</script>

<script src="<?=PROOT?>js/select2.js"></script>
<script>
// script to parent select
function formatCollege(data) {
    // console.log(data);
    
    if (data.loading) {
        return data.text;
    }
    if (data.id) {
        var markup = "<div class='select2-result-data clearfix'>" +
            "<div class='select2-result-data__title1'>" + data.id + ' : ' + data.name + "</div>";
        markup += "<div class='select2-result-data__title2'>" + data.city + ', ' + data.state + ', ' + data.country + "</div>" +
            "</div>";
        return markup;
    }
}
function formatCollegeSelection(data) {
    return data.text || data.id +': '+data.name+', '+data.city+', '+data.state;
}



// function to select parent using select2 -- ajax
// select2 listener and data fetch for #parent
$parent = $(".parent-select");

$parent.select2({
    width: '200px',
    minimumInputLength: 1,
    placeholder: 'Type to Search College',
    delay: 250,
    ajax: {
        url: '/contentman/college/ajaxcollege',
        dataType: "json",
        type: "GET",
        data: function (params) {

            var queryParameters = {
                q: params.term,
                l: 10,
                p: params.page
            }
            return queryParameters;
        },
        processResults: function (data, params) {
            params.page = params.page || 1;
            if (data.totalResults == 0) {
                data.results = [];
            }
            return {
                results: data.results,
                pagination: {
                    more: (params.page * 10) < data.totalResults
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    }, // let our custom formatter work
    templateResult: formatCollege,
    templateSelection: formatCollegeSelection
});


$(document).ready(function () {

    $(".parent-select").each(function (index, element) {
        var init_par_id = $(element).find('option').val();
        if(init_par_id != 0) {

            // var $option = $("<option selected> Loading... </option>").val(init_par_id);
            // $(element).html($option).trigger('change');

            $.ajax({
            type: "GET",
            url: "/contentman/college/ajaxcollege",
            data: {
                q: init_par_id
            },
            dataType: "json",
            success: function (response) {
                $(element).html('<option value="'+response.results[0].id+'" selected>'+response.results[0].id+': '+response.results[0].name+'</option>');
                $(element).removeData();
                $(element).trigger('change');
            }
        });
        
        }

    });

    
        $(".parent-select").on('change', function(event) {
            var id = $(event.target).attr('data-id');
            var par = $(event.target).find('option:selected').val();

            $.ajax({
                type: "post",
                url: "/contentman/college/update",
                data: {
                    action: 'updateparent',
                    id: id,
                    parent: par
                },
                dataType: "json",
                success: function (response) {
                    if(response == 'success') {
                        console.log("success");
                        
                    }
                }
            });

        });

});


</script>


<script>

$('#cdinput').keyup(function(event) {
    $div = $(event.target).nextElementSibling;
    console.log("keyup");
    $.ajax({
        type: "post",
        url: "/contentman/college/ajaxCDcollege",
        data: {
            q:  $(event.target).val(),
            l:  30
        },
        dataType: "json",
        success: function (response) {
            html = '';
            // console.log(response.results.length);

            if (response.results){
                for (let i = 0; i < response.results.length; i++) {
                    const el = response.results[i];
                    edited = '';
                    if(el.edited == 1) {
                        edited = ' edited';
                    }
                    html += '<span><input type="number" style="width:50px" class="cdcollege'+edited+'" name="" value="'+el.new_id+'" data-id="'+el.new_id+'">'+el.name
                    +'<br>'+'<span style="font-size:14px">'+el.alias+'</span>'
                    +'</span>';

                }
                console.log(html);
                $('#cdclg').html(html);
            }
        }
    });
});

$(document).on('keyup', '.cdcollege', function(event){
    $el = $(event.target);
    console.log($el.val());

    $.ajax({
        type: "post",
        url: "/contentman/college/update",
        data: {
            action: 'updateCD',
            id: $el.attr('data-id'),
            newID: $el.val()
        },
        success: function (response) {
            if(response == 'success'){
                $el.addClass('edited');
            } else {
                $el.attr('style', "3px solid red");
            }
        }
    });

});

</script>

<script>

$('#cpinput').keyup(function(event) {
    $div = $(event.target).nextElementSibling;
    console.log("keyup");
    $.ajax({
        type: "post",
        url: "/contentman/college/ajaxCPcollege",
        data: {
            q:  $(event.target).val(),
            l:  30
        },
        dataType: "json",
        success: function (response) {
            html = '';
            // console.log(response.results.length);

            if (response.results){
                for (let i = 0; i < response.results.length; i++) {
                    const el = response.results[i];
                    edited = '';
                    if(el.edited == 1) {
                        edited = ' edited';
                    }
                    html += '<span><input type="number" style="width:50px" class="cpcollege'+edited+'" name="" value="'+el.new_id+'" data-id="'+el.new_id+'">'+el.name
                    +'<br>'+'<span style="font-size:14px">'+el.alias+'</span>'
                    +'</span>';

                }
                console.log(html);
                $('#cpclg').html(html);
            }
        }
    });
});

$(document).on('keyup', '.cpcollege', function(event){
    $el = $(event.target);
    console.log($el.val());

    $.ajax({
        type: "post",
        url: "/contentman/college/update",
        data: {
            action: 'updateCP',
            id: $el.attr('data-id'),
            newID: $el.val()
        },
        success: function (response) {
            if(response == 'success'){
                $el.addClass('edited');
            } else {
                $el.attr('style', "3px solid red");
            }
        }
    });

});

</script>


<?php $this->end(); ?>