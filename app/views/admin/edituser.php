<?php $this->setLayout('admin_layout');?>
<?php $this->setSiteTitle('Edit User');?>

<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>css/datepicker.css">
<link rel="stylesheet" href="<?=PROOT?>css/multiselect.css">
<link rel="stylesheet" href="<?=PROOT?>css/croppie.css">
<link rel="stylesheet" href="<?=PROOT?>css/selectize.css">
<meta content="some/meta" />
<script src="<?=PROOT?>js/jquery.js"></script>
<script src="<?=PROOT?>js/datepicker.js"></script>
<script src="<?=PROOT?>js/multiselect.js"></script>
<script src="<?=PROOT?>js/croppie.js"></script>
<script src="<?=PROOT?>js/selectize.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<h1 class="page-title">User Details</h1>

<div class="global-content">
    <div class="main-content">
        <div class="tool-cont">
            USER INFO
        </div>
        <div class="content">
            <div class="image-cont">
                <div class="profile-pic-cont">
                    <img class="profile-pic" id="profile-pic" src="<?php
                        if (!empty($this->userpicture)) {
                            echo PIROOT.$this->userpicture;
                        } else {
                            echo IROOT.'noimage.jpg';
                        }
                    ?>"
                        alt="user image">
                </div>
                <button class="btn btn-blue" data-toggle="profile-pic">Change/Upload</button>
            </div>

            <!-- error modal -->
            <div class="error-modal">
                <div>
                    <img src="<?=IROOT.'public/failed.gif'?>" alt="">
                </div>
            </div>

            <!-- success modal -->
            <div class="success-modal">
                <div>
                    <img src="<?=IROOT.'public/success.gif'?>" alt="">
                </div>
            </div>


            <!-- overlay to change profile pic -->
            <div class="modal modal-overlay">
                <div class="modal-wrap">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Change or Upload Image</h5>
                            <button class="btn btn-sqare" data-dismiss="modal">x</button>
                        </div>
                        <div class="modal-body">
                            <div class="img-canvas">
                                <img src="" alt="" id="picture">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-red float-left" data-dismiss="modal">Close</button>
                            <button id="submit-image" class="btn btn-red float-right">Upload &amp; Save Image</button>
                            <button id="picture-select" class="btn btn-blue float-right">Select Image</button>
                            <input type="file" name="picture" id="picture-input" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <form action="" id="edituser" class="form" method="post">

                <div class="form-group">
                    <div>
                        <?=$this->displayErrors?>
                    </div>
                </div>
                

                <div class="form-caption">Basic Info</div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?=$this->userdata['username'];?>">
                    <div class="help">Required. Max 150 characters (Unique) </div>
                </div>
                <div class="form-group">
                    <label for="pass_message">Password </label>
                    <div class="message">
                        **Raw Passwords are not stored. So you cannot view them.** <br>
                        New Password:
                        <input type="password" name="password" id="password" value="">
                        Confirm Password:
                        <input type="password" name="confirm" id="confirm" value="">
                    </div>
                </div>

                <div class="form-caption">Personal info</div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?=$this->userdata['email'];?>">
                    <div class="help">Required. Max 150 characters (Unique)</div>
                </div>
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" value="<?=$this->userdata['fname'];?>">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" value="<?=$this->userdata['lname'];?>">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="field-container">
                        <div>
                            <select name="gender" id="gender">
                                <?php 
                                foreach (['MALE', 'FEMALE', 'OTHER'] as $gender) {
                                    if($gender == $this->userdata['gender']) {
                                        echo '<option value="'.$gender.'" selected>'.ucfirst($gender).'</option>';
                                    } else {
                                        echo '<option value="'.$gender.'" >'.ucfirst($gender).'</option>';
                                    }
                                }
                                
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="text" name="dob" id="dob" value="<?=$this->userdata['dob'];?>">
                    <div class="help"> Use Datepicker to fill DOB. </div>
                </div>

                

                <div class="form-group">
                    <label for="is_superuser"> Is SuperUser</label>
                    <input type="checkbox" name="is_superuser" id="is_superuser">
                    <div class="help"> Explicitly provide all the permissions to the User. </div>
                    <!-- <input type="text" name="is_superuser" id="is_superuser" value="<?=$this->userdata['dob'];?>"> -->
                </div>

                <div class="form-group">
                    <label for="roles"> Roles </label>
                    <div class="field-container">
                        <div>
                            <select name="roles[]" id="roles" multiple="multiple">
                                <?php 
                                foreach ($this->roles as $role) {
                                    if(!empty($this->userroles) && in_array($role, $this->userroles)) {
                                        echo '<option value="'.$role.'" selected>'.ucfirst($role).'</option>';
                                    } else {
                                        echo '<option value="'.$role.'" >'.ucfirst($role).'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="disable">Disable User</label>
                    <input type="checkbox" name="disable" id="disable">
                    <div class="help"> Disable User instead of deleting account. </div>
                    <!-- <input type="text" name="disable" id="disable" value="<?=$this->userdata['dob'];?>"> -->
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-blue float-right" value="Submit">
                    <a class="btn btn-red float-left" onclick="return confirm('Are you Sure want to Delete this accout PERMANENTLY? This step cannot be reversed back.');" href="<?=PROOT.'admin/user/'.$this->userid.'/delete'?>">Permanently Delete Account</a>
                </div>
            </form>
        </div>
    </div>


    <div class="related-content">
        <div class="card1">

        </div>
    </div>
</div>

<script>
    $("#dob").datepicker({
        'format': 'dd-mm-yyyy'
    });
</script>


<script>
    $('#gender').selectize();
</script>
<!-- <script>
$(function() {
  var basic = $('#picture-cropper').croppie({
    viewport: {
      width: 200,
      height: 200
    }
  });
  basic.croppie('bind', {
    url: '/img/profile/index.jpg',
    points: [77, 469, 280, 739]
  });
});
</script> -->

<script>
    $('[data-toggle="profile-pic"]').click(function () {
        $('.modal-overlay').show();
    });

    $('[data-dismiss="modal"]').click(function () {
        $('.modal-overlay').hide();
    });

    $('.modal #picture-select').click(function () {
        $('.modal #picture-input').click();
    });
</script>

<script>
    $('#roles').multiSelect({
        selectableHeader: '<div class="select-header"> Available Roles</div>',
        selectionHeader: '<div class="select-header"> Selected Roles</div>',
    });
</script>

<script>
    // variable to check the status of croppie
    var croppie_binded = false;
    $('.modal #picture-input').on('change', function () {
        if (croppie_binded == true) {
            $('#picture').croppie('destroy');
        }
        $image_crop = $('#picture').croppie({
            enableExif: true,
            viewport: {
                width: 300,
                height: 300,
                type: 'square'
            },
            boundary: {
                width: 400,
                height: 400
            }
        });
        var reader = new FileReader();
        console.log("loging to probe");
        console.log(reader);
        reader.onload = function (event) {
            console.log("reader.onload");
            // destroy the previous instance of croppie

            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function () {
                console.log('jQuery bind complete.');
                croppie_binded = true;
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.modal #submit-image').click(function (event) {
        console.log(event);
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 500
        }).then(function (response) {
            $.ajax({
                type: "POST",
                url: "<?=PROOT.'admin/user/'.$this->userid.'/changeimage'?>",
                data: {
                    "image": response
                },
                success: function (response) {
                    $('.modal').hide();
                    if (response.status == 'success') {
                        $('.success-modal').show();
                        $('#profile-pic').attr('src', response.imgurl);
                        setTimeout(() => {
                            $('.success-modal').hide();
                        }, 2000);
                    } else {
                        $('.failed-modal').show();
                        setTimeout(() => {
                            $('.failed-modal').hide();
                        }, 2000);
                    }
                }
            });
        })
    })
</script>

<?php $this->end(); ?>