'use strict'


var createExamQuestion = {};

(function(createExamQuestion){

    createExamQuestion.elements = {
        submitBtn : '#js_submit_exam_question',
        formSave : '#js_form_exam_question'
    }

    createExamQuestion.init = () => {
        createExamQuestion.bindControls();
    }

    createExamQuestion.bindControls = () => {

        $(document).on('click', createExamQuestion.elements.submitBtn, function (e) {
                e.preventDefault();
                $(createExamQuestion.elements.formSave).submit();
        })

        $(createExamQuestion.elements.formSave).validate({
            rules: {
                exam_id: {
                    required: true
                },
                question_id: {
                    required: false,
                }
            },
            submitHandler: function (form) {
                var formData = new FormData($(createExamQuestion.elements.formSave)[0]);
                $.ajax({
                    type: "POST",
                    url: EXAM_QUESTION_STORE_URL,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function (res) {
                        if(res.status == true) {
                            Swal.fire(
                                'Success!',
                                res.msg,
                                'success'
                                );
                                location.reload();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    },
                });
            },
        });
    }

})(createExamQuestion);


$(document).on('click', '.js_delete_question', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: EXAM_QUESTION_DELETE_URL,
        data: {
            id : $(this).data('id')
        },
        cache: false,
        dataType: 'JSON',
        success: function (res) {
            if(res.status == true) {
                Swal.fire(
                    'Success!',
                    res.msg,
                    'success'
                    );
                    location.reload();
            }
        },
        error: function (xhr) {
            console.log(xhr);
        },
    });
})

$(document).on('click', '.js_add_question', function (e) {
    var id = $(this).data('id');
    var BaseUrl =$('#BaseUrl').val();
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: EXAM_QUESTION_STORE_URL,
        data: {
            question_id : $(this).data('id'),
            exam_id : $('#js_exam_id').val()
        },
        cache: false,
        dataType: 'JSON',
        success: function (res) {
            if(res.status == true) {
                $('#js_text'+id).html('Remove');
                if(res.data.question_type == 2){
                    $('#js_question_section').show();
                    $('#js_question_type_2').show();
                    $('#js_question').val(res.data.question);
                    $('#js_mark').val(res.data.score);
                    var correctAnswer = '#js_'+res.data.answer_options[0].answer_option_id;
                    $(correctAnswer).prop('checked', true);
                    $("#js_image_1").attr('src', BaseUrl+ '/storage/questions/'+ res.data.answer_options[0].image);
                    $("#js_image_2").attr('src', BaseUrl+ '/storage/questions/'+ res.data.answer_options[1].image);
                    $("#js_image_3").attr('src', BaseUrl+ '/storage/questions/'+ res.data.answer_options[2].image);
                    $("#js_image_4").attr('src', BaseUrl+ '/storage/questions/'+ res.data.answer_options[3].image);
                    $('#js_question_id').val(res.data.question_id);
                } 
            }
        },
        error: function (xhr) {
            console.log(xhr);
        },
    });
})


$(document).on('click', '.js_remove_qstn', function (e) {
    e.preventDefault();
    console.log($(this).data('id'));
    $.ajax({
        type: "POST",
        url: EXAM_QUESTION_DELETE_URL,
        data: {
            id : $(this).data('id')
        },
        cache: false,
        dataType: 'JSON',
        success: function (res) {
            if(res.status == true) {
                Swal.fire(
                    'Success!',
                    res.msg,
                    'success'
                    );
            }
        },
        error: function (xhr) {
            console.log(xhr);
        },
    });
})



$(document).ready(function() {
    $('#js_question_section').hide();
    $('#js_question_type_2').hide();
});