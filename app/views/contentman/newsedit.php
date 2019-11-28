<?php 
$this->setLayout('contentman_layout');?>
<?php $this->setSiteTitle('Edit News');?>

<?php $this->start('head'); ?>
<!-- Required CSS -->
<link rel="stylesheet" href="<?=PROOT?>css/datepicker.css">
<link rel="stylesheet" href="<?=PROOT?>css/select2.css">
<link rel="stylesheet" href="<?=PROOT?>css/selectize.css">
<!-- Required JS -->
<script src="<?=PROOT?>js/jquery.js"></script>
<script src="<?=PROOT?>js/datepicker.js"></script>
<script src="<?=PROOT?>js/selectize.js"></script>
<script src="<?=PROOT?>js/select2.js"></script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="formfield-wrapper">
    <div class="formfield-container">
        <div class="inputfield-container">
            <span class="title-label float-left">Post Title</span>
            <input class="float-left" type="text" name="title" id="title" value="<?=$this->resultdata->title?>">
            <!-- autosave indicator -->
            <div class="status-spinner"><div id="status-spinner"></div></div>
            <span id="save-status" class="save-status float-left">Waiting</span>
            <?php if ($this->resultdata->published != 1) : ?>
                <button class="btn btn-green float-right" id="publish-btn">Publish</button>
            <?php endif; ?>
            <button class="btn btn-blue float-right" id="save-btn">Save</button>
            <span class="posting float-right">Posting as
                <span>
                <img class="profile-image-small" src="<?=$this->profileimg?>" alt=""> <?=$this->userdata->fname?>
                </span> 
            </span>
        </div>
        <div class="textfield-container">

            <div id="toolbar" class="toolbar-container"></div>
            <!-- main text content -->
            <div class="content-container">
                <div class="text-content" id="content">
                <?=$this->resultdata->content?>
                </div>
            </div>

        </div>

        <div class="sidefield-container">
            <div id="related-content">
                <!-- Category -->
                <button class="active-btn">Category</button>
                <div class="active-btn-content">
                    <select name="category" id="category">
                        <?php
                            foreach (['EXAM', 'ADMISSION','COLLEGE', 'SARKARI','JOB'] as $key ) {
                                if($this->resultdata->category == $key) {
                                    echo '<option value="'.$key.'" selected>'.$key.'</option>';
                                } else {
                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                }
                            }
                        ?>
                    </select>
                    <div class="help">Choose appropriate category</div>
                </div>
                <!-- Parent -->
                <button class="active-btn">Parent</button>
                <div class="active-btn-content">
                    <select name="parent" id="parent">
                        <?php
                            if(!empty($this->resultdata->parent)) {
                                echo '<option value="'.$this->resultdata->parent.'" selected></option>';
                            }
                        ?>
                    </select>
                    <div class="help">Choose appropriate Parent News</div>
                </div>
                <!-- Related Colleges -->
                <button class="active-btn">Related Colleges</button>
                <div class="active-btn-content">
                    <select name="related_colleges[]" id="related_colleges" multiple="multiple">
                        <?php
                            $related_colleges = json_decode($this->resultdata->related_colleges, true);
                            if(!empty($related_colleges)) {
                                foreach ($related_colleges as $key => $value) {
                                    echo '<option value="'.$value.'" selected></option>';
                                }
                            }
                        ?>
                    </select>
                    <div class="help">Choose appropriate Colleges</div>
                </div>
                <!-- Related Exams -->
                <button class="active-btn">Related Exams</button>
                <div class="active-btn-content">
                    <select name="related_exams[]" id="related_exams" multiple="multiple">
                        <!-- <option value="NONE">NONE</option> -->
                    </select>
                    <div class="help">Choose appropriate Exams</div>
                </div>
                <!-- Related Jobs -->
                <button class="active-btn">Related Jobs</button>
                <div class="active-btn-content">
                    <select name="related_jobs[]" id="related_jobs" multiple="multiple">
                        <!-- <option value="NONE">NONE</option> -->
                    </select>
                    <div class="help">Choose appropriate Exams</div>
                </div>
                <!-- Priority -->
                <button class="active-btn">Priority</button>
                <div class="active-btn-content">
                    <select name="priority" id="priority">
                        <?php
                            foreach (['DEFAULT', 'LOW', 'VERY_LOW','HIGH', 'VERY_HIGH'] as $key ) {
                                if($this->resultdata->priority == $key) {
                                    echo '<option value="'.$key.'" selected>'.$key.'</option>';
                                } else {
                                    echo '<option value="'.$key.'">'.$key.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <!-- Description -->
                <button class="active-btn">Description</button>
                <div class="active-btn-content">
                    <textarea name="desc" id="desc" ><?=$this->resultdata->desc?></textarea>
                </div>
                <!-- Tags -->
                <button class="active-btn">Tags</button>
                <div class="active-btn-content">
                    <select name="tags" id="tags" multiple="multiple">
                        <?php
                            $tags = json_decode($this->resultdata->tags);
                            if(!empty($tags) && $tags != null) {
                                foreach ($tags as $key) {
                                    echo '<option value="'.$key.'" selected>'.$key.'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <!-- Permalinnk Alias -->
                <button class="active-btn">Permalink</button>
                <div class="active-btn-content">
                    <label for="alias">https://collegetalash.com.test/news/</label>
                    <input type="text" name="alias" id="alias" value="<?=$this->resultdata->alias?>">
                </div>
                <!-- Status -->
                <button class="active-btn">Status</button>
                <div class="active-btn-content">
                    <?php if($this->resultdata->status == 'A'):?>  
                    <input type="radio" name="status" value="A" id="status" checked>Active
                    <input type="radio" name="status" value="I" id="status">Inactive
                    <?php else: ?>
                    <input type="radio" name="status" value="A" id="status">Active
                    <input type="radio" name="status" value="I" id="status" checked>Inactive
                    <?php endif; ?>
                </div>
                <button class="">Advanced</button>
                <div class="">
                    <a href="<?=PROOT?>contentman/news/<?=$this->resultdata->id?>/delete" class="btn btn-red">Permanent Delete News</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->end(); ?>

<?php $this->start('script'); ?>
<!-- Required JS -->

<script src="<?=PROOT?>js/jquery.js"></script>
<script src="<?=PROOT?>js/datepicker.js"></script>
<script src="<?=PROOT?>js/selectize.js"></script>
<script src="<?=PROOT?>js/select2.js"></script>
<!-- <script src="<?=PROOT?>js/ckeditor.js"></script> -->
<script src="<?=PROOT?>js/tinymce/tinymce.min.js"></script>
<script src="<?=PROOT?>js/newsedit.js"></script>

<?php $this->end(); ?>