/**
 * Created by Gado on 4/30/2017.
 */
$(function () {
    //alert('Document is ready');

    $('#govSelect').on("change", function () {
        var sel_gov = $(this).val();
        //alert('You picked: ' + sel_city);

        if (!sel_gov) {} else {
            $.ajax({
                type: "POST",
                url: "androidCityByGov-ar.php",
                data: 'theOption=' + sel_gov,
                success: function (whatigot) {
                    //alert('Server-side response: ' + whatigot);
                    $('#citySelect').html(whatigot);

                    //document.getElementById("result").innerHTML = whatigot;
                } //END success fn
            }); //END $.ajax
        }
    }); //END dropdown change event

    // using event delegation
    $('#ajax-demo').on("change", "#selcity", function () {
        var sel_city = $(this).val();
        //alert('You picked: ' + sel_city);

        if (!sel_city) {} else {
            $.ajax({
                type: "POST",
                url: "androidHospitalsByCity-ar.php",
                data: 'theOption=' + sel_city,
                success: function (whatigot) {
                    //alert('Server-side response: ' + whatigot);
                    $('#hospitalsByCity').html(whatigot);
                    //document.getElementById("result").innerHTML = whatigot;
                }
                //END success fn
            }); //END $.ajax
        }
    }); //END dropdown change event

    //Submit city and hospital choice in index to get departments
    $('#submit').on("click", function (e) {


        var sel_hos = $('#selHos').val();
        //alert('You picked: ' + sel_hos);

        if (sel_hos == null || sel_hos == "") {
            swal({
                type: 'error',
                text: 'يجب عليك أولاً اختيار مشفى',
                background: '#cacaca',
                width: 300
            });
            e.preventDefault();
            //alert("You must select a Hospital First" + sel_hos);

        } else {
            $.ajax({
                type: "POST",
                url: "hospitalDepartments-ar.php",
                data: 'theOption=' + sel_hos,
                success: function (whatigot) {
                    //alert('Server-side response: ' + whatigot);
                    if (whatigot == "error") {
                        swal(
                            'Error',
                            'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                            'error'
                        )
                    } else {
                        $('#hospitalDepartments').html(whatigot);
                    }

                    //document.getElementById("result").innerHTML = whatigot;
                } //END success fn
            }); //END $.ajax
            e.preventDefault();
        }
    }); //END submit click event


    $('#feedback').on("submit", function (e) {

        var name = $("#feedback input[name=name]").val();
        var email = $("#feedback input[name=email]").val();
        var message = $("#feedback textarea[name=message]").val();

        //alert('You picked: ' + name );

        if (name == null || name == "") {
            alert("لا تنسى ان تزودنا باسمك");
            e.preventDefault();
        } else if (message == null || message == "") {
            alert("شاركنا ما تفكر به, اجعل رسالتك بناءة");
            e.preventDefault();
        } else {
            $.ajax({
                type: 'post',
                url: 'sendFeedback.php',
                data: {
                    submit: 'submit',
                    data: $("#feedback").serialize()
                },
                success: function (response) {
                    //alert('Server-side response: ' + response);
                    if (response == "success") {

                        $("#feedback input[name=name]").val("");
                        $("#feedback input[name=email]").val("");
                        $("#feedback textarea[name=message]").val("");

                        swal({
                            title: 'عمل جيد!',
                            text: "تم الإرسال بنجاح!",
                            type: 'success'
                        })
                    } else {
                        swal({
                            title: 'Error',
                            text: 'لقد حدث خطأ ما, برجاء إعادة المحاولة',
                            type: 'error',
                            timer: 3000
                        })

                    }
                }
            });
            e.preventDefault();
        }

    }); //END dropdown change event


    //####### on page load, retrive votes for each content
    $.each($('.voting_wrapper'), function () {

        //retrive unique id from this voting_wrapper element
        var unique_id = $(this).attr("id");

        //prepare post content
        post_data = {
            'unique_id': unique_id,
            'vote': 'fetch'
        };

        //send our data to "vote_process.php" using jQuery $.post()
        $.post('vote_process.php', post_data, function (response) {

            //retrive votes from server, replace each vote count text
            $('#' + unique_id + ' .up_votes').text(response.vote_up);
            $('#' + unique_id + ' .down_votes').text(response.vote_down);
        }, 'json');
    });

    $(".voting_wrapper .voting_btn").click(function (e) {

        //get class name (down_button / up_button) of clicked element
        var clicked_button = $(this).children().attr('class');

        //get unique ID from voted parent element
        var unique_id = $(this).parent().attr("id");

        if (clicked_button === 'down_button') //user disliked the content
        {
            //prepare post content
            post_data = {
                'unique_id': unique_id,
                'vote': 'down'
            };

            //send our data to "vote_process.php" using jQuery $.post()
            $.post('vote_process.php', post_data, function (data) {

                //replace vote down count text with new values
                $('#' + unique_id + ' .down_votes').text(data);

                //thank user for the dislike
                alert("نأسف لذلك, سنحاول تدارك أخطائنا");

            }).fail(function (err) {

                //alert user about the HTTP server error
                alert(err.statusText);
            });
        } else if (clicked_button === 'up_button') //user liked the content
        {
            //prepare post content
            post_data = {
                'unique_id': unique_id,
                'vote': 'up'
            };

            //send our data to "vote_process.php" using jQuery $.post()
            $.post('vote_process.php', post_data, function (data) {

                //replace vote up count text with new values
                $('#' + unique_id + ' .up_votes').text(data);

                //thank user for liking the content
                swal({
                    title: 'شكراً لك!',
                    text: "لتقدير جهودنا!",
                    type: 'success'
                })
            }).fail(function (err) {

                //alert user about the HTTP server error
                alert(err.statusText);
            });
        }

    });
    //end

}); //END document.ready
