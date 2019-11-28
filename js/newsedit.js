function fileBrowser(callback, value, meta) {
    tinymce.activeEditor.windowManager.open({
        file: '/include/plugins/elfinder/filemanager.html', // use an absolute path!
        title: 'File Browser',
        width: 900,
        height: 450
    }, {
        oninsert: function (file, fm) {
            var url, reg, info;

            // URL normalization -- skipped
            // url = fm.convAbsUrl(file.url);
            url = file.url;

            // Make file info
            info = file.name;

            // Provide file and text for the link dialog
            if (meta.filetype == 'file') {
                callback(url, {
                    text: info,
                    title: info
                });
            }

            // Provide image and alt text for the image dialog
            if (meta.filetype == 'image') {
                callback(url, {
                    alt: info
                });
            }

            // Provide alternative source and posted for the media dialog
            if (meta.filetype == 'media') {
                callback(url);
            }
        }
    });
    return false;
}

tinymce.init({
    selector: '#content',
    inline: true,
    autofocus: true,
    fixed_toolbar_container: "#toolbar",
    fixed_toolbar_width: autosave,
    height: 500,
    width: "100%",
    theme: 'modern',
    plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
    toolbar1: 'undo redo | formatselect | bold italic strikethrough forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
    image_advtab: true,
    file_picker_callback: fileBrowser,
    convert_urls: false,
    table_responsive_width: true,
    style_formats: [{
            title: 'Image Left',
            selector: 'img',
            styles: {
                'float': 'left',
                'margin': '0 10px 0 10px'
            }
        },
        {
            title: 'Image Right',
            selector: 'img',
            styles: {
                'float': 'right',
                'margin': '0 10px 0 10px'
            }
        }
    ],
    templates: [{
            title: 'Test template 1',
            content: 'Test 1'
        },
        {
            title: 'Test template 2',
            content: 'Test 2'
        }
    ],
    content_css: [
        '//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i',
    ],
    init_instance_callback: function (editor) {
        // This will trick the editor into thinking it was focused
        // without actually focusing it (causing the toolbar to appear)
        editor.fire('focus');
        // call autosave function on keypress
        editor.on('Change', function (e) {
            console.log("text changed");
            autosave_manager();
        });
    },
    setup: function (editor) {
        // This prevents the blur event from hiding the toolbar
        editor.on('blur', function () {
            return false;
        });
        // Append the <table> html with <div> -- hack
        editor.on('BeforeSetContent', function(e) {
			if (e.content.indexOf("<table") == 0) {
                e.content = '<div class="table-responsive">' + e.content + '</div>';
			}
        });
    }
});

var autosaveTimeout;

function autosave_manager() {
    clearTimeout(autosaveTimeout);
    console.log("timeout clear");
    autosaveTimeout = setTimeout(function () {
        autosave();
    }, 3000);
    console.log("timeout set");
}

$("#save-btn").click(function (e) {
    clearTimeout(autosaveTimeout);
    autosave();
});

var autosave_timer;

function autosave_retry() {
    $('#status-spinner').removeClass('busy');
    $('#save-status').html('<span style="color:red">Autosave Failed</span>');
    autosave_timer = 4;
    var intr = setInterval(function () {
        $('#save-status').html('Retrying in ' + autosave_timer-- + ' seconds.');
    }, 1000)
    setTimeout(function () {
        clearInterval(intr);
        autosave();
    }, 5000)
}

// autosave function declaration ----

function autosave() {
    var dec_html = tinymce.activeEditor.getContent();
    var title = $('#title').val();
    var alias = $('#alias').val();
    var category = $('#category').val();
    var desc = $('#desc').val();
    var content = dec_html;
    var priority = $('#priority').val();
    var parent = $('#parent').val();
    var tags = $('#tags').val();
    var related_colleges = $('#related_colleges').val();
    var related_exams = $('#related_exams').val();
    var related_jobs = $('#related_jobs').val();
    var status = $('#status:checked').val();

    $('#status-spinner').addClass('busy');
    $('#save-status').html('Autosaving...');
    $.ajax({
        type: "post",
        url: "",
        data: {
            'action': 'save',
            'title': title,
            'alias': alias,
            'category': category,
            'desc': desc,
            'content': content,
            'parent': parent,
            'priority': priority,
            'tags': tags,
            'related_colleges': related_colleges,
            'related_exams': related_exams,
            'related_jobs': related_jobs,
            'status': status,
        },
        success: function (response) {
            if (response == 'saved') {
                $('#save-status').html('Done');
                setTimeout(function () {
                    $('#save-status').html('');
                }, 2000);
                $('#status-spinner').removeClass('busy');
            } else {
                autosave_retry();
            }
        },
        error: function (xhr, error) {
            console.log("ERROR: Unable to connect to server.");
            autosave_retry();
        }
    });
}

$("#publish-btn").click(function (event) {
    publish();
});


function publish_retry() {
    $('#status-spinner').removeClass('busy');
    $('#save-status').html('<span style="color:red">Publish Failed</span>');
    autosave_timer = 4;
    var intr = setInterval(function () {
        $('#save-status').html('Retrying Publishing in ' + autosave_timer-- + ' seconds.');
    }, 1000)
    setTimeout(function () {
        clearInterval(intr);
        publish();
    }, 5000)
}

function publish() {
    var dec_html = tinymce.activeEditor.getContent();
    var title = $('#title').val();
    var alias = $('#alias').val();
    var category = $('#category').val();
    var desc = $('#desc').val();
    var content = dec_html;
    var priority = $('#priority').val();
    var parent = $('#parent').val();
    var tags = $('#tags').val();
    var related_colleges = $('#related_colleges').val();
    var related_exams = $('#related_exams').val();
    var related_jobs = $('#related_jobs').val();
    var status = $('#status:checked').val();

    $('#status-spinner').addClass('busy');
    $('#save-status').html('Publishing...');
    $.ajax({
        type: "post",
        url: "",
        data: {
            'action': 'publish',
            'title': title,
            'alias': alias,
            'category': category,
            'desc': desc,
            'content': content,
            'parent': parent,
            'priority': priority,
            'tags': tags,
            'related_colleges': related_colleges,
            'related_exams': related_exams,
            'related_jobs': related_jobs,
            'status': status,
        },
        success: function (response) {
            if (response == 'published') {
                $('#save-status').html('Done');
                setTimeout(function () {
                    $('#save-status').html('');
                }, 2000);
                $('#status-spinner').removeClass('busy');
                window.location.href = "/contentman/news";
            } else {
                publish_retry();
            }
        },
        error: function () {
            console.log("ERROR: Unable to connect to server.");
            publish_retry();
        }
    });
}


// // event listener for category change
// $cat_span = $('#cat-span');
// $("#category").on('change', function (event) {
//     option_text = $("#category").find("option:selected");
//     $cat_span.html(option_text.val().toLowerCase());
// });



// --------------------------------------------------------------------------------
// configuration for select2
// --------------------------------------------------------------------------------

// select2 functions to format news
function formatNews(data) {
    if (data.loading) {
        return data.text;
    }
    if (data) {
        var markup = "<div class='select2-result-data clearfix'>" +
            "<div class='select2-result-data__title1'>" + data.title + "</div>";
        markup += "<div class='select2-result-data__title2'>" + data.alias + "</div>" +
            "</div>";
        return markup;
    }
}
function formatNewsSelection(data) {
    return data.text || data.title;
}
// select2 function to format colleges
function formatCollege(data) {
    if (data.loading) {
        return data.text;
    }
    if (data.id) {
        var markup = "<div class='select2-result-data clearfix'>" +
            "<div class='select2-result-data__title1'>" + data.name + "</div>";
        markup += "<div class='select2-result-data__title2'>" + data.city + ', ' + data.state + ', ' + data.country + "</div>" +
            "</div>";
        return markup;
    }
}
function formatCollegeSelection(data) {
    return data.text || data.name+', '+data.city+', '+data.state;
}

// function to select tags using select2
$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
    var oldRemoveChoice = Search.prototype.searchRemoveChoice;

    Search.prototype.searchRemoveChoice = function () {
        oldRemoveChoice.apply(this, arguments);
        this.$search.val('');
    };

    $('#tags').select2({
        width: '100%',
        tags: true,
        tokenSeparators: [',']
    });
});

// function to select priority using select2
$('#priority').select2({
    width: '100%'
});

//function to select category using select2
$('#category').select2({
    width: '100%'
});

// function to select parent using select2 -- ajax
// select2 listener and data fetch for #parent
$parent = $("#parent");
$parent.select2({
    width: '100%',
    minimumInputLength: 1,
    placeholder: 'Type to Search News',
    delay: 250,
    ajax: {
        url: '/contentman/news/ajaxnews',
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
    templateResult: formatNews,
    templateSelection: formatNewsSelection
});

// to load the parent data...
$(document).ready(function () {
    var initial_parent_id = $("#parent").find("option").val();
    var $option = $("<option selected> Loading... </option>").val(initial_parent_id);
    $parent.html($option).trigger('change');

$.ajax({
    type: "GET",
    url: "/contentman/news/ajaxnews",
    data: {
        q: initial_parent_id
    },
    dataType: "json",
    success: function (response) {
        $option.text(response.results[0].title).val(initial_parent_id);
        $option.removeData();
        $parent.trigger('change');
    }
});
});


// function to select related_colleges using select2 -- ajax
$related_colleges = $("#related_colleges");
$related_colleges.select2({
    width: '100%',
    minimumInputLength: 1,
    placeholder: 'Type to Search Colleges',
    tags: true,
    tokenSeparators: [','],
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

// to load the college data...
const initial_college_ids = $("#related_colleges").find("option");
var option = '<option value=""> Loading ... </option>';
$related_colleges.html(option);
$related_colleges.removeData();
$related_colleges.trigger('change');
var options = '';
for (let i = 0; i < initial_college_ids.length; i++) {
    const element = initial_college_ids[i].value;
    $.ajax({
        type: "GET",
        url: "/contentman/college/ajaxcollege",
        data: {
            q: element
        },
        dataType: "json",
        success: function (response) {
            data = response.results[0];
            options += '<option value="'+data.id+'" selected>'+ data.name+', '+data.city+', '+data.state +'</option>';
            if(i == initial_college_ids.length-1){
                $related_colleges.html(options);
                $related_colleges.removeData();
                $related_colleges.trigger('change');
            }
        }
    });
}



$related_content = document.querySelector('#related-content');

$rbtn = $related_content.querySelectorAll('button');

$rbtn.forEach(element => {
    element.addEventListener('click', function(event) {
        event.target.classList.toggle('active-btn');
        event.target.nextElementSibling.classList.toggle('active-btn-content');
    });
});
