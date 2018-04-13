$(function () {
    $('#form').submit(function (e) {
        e.preventDefault()  // prevent the form from 'submitting'
        var name=$('#name').val();
        //$("#send").css("background-color", "green");
        $("#send").css({"background-color": "green", "border-color": "green"});
        $("#send").text("Thank you, "+name);
        })
    })
