
/*
Login fail message fadeout
 */
$(function(){
    $("#loginfail").fadeOut(5000);
});

/*
Hide file submit form
 */
$(function(){
    $("#form-hide").hide();
});

/*
ajax function for provisioning Jabber
 */
$(function(){
    $(".requestRow").each( function() {
        var element = $(this);
        $.ajax({
            url: "ajax/addJabber.php",
            type: "POST",
            dataType : 'json',
            async: false,
            data: {
                userId: element.find(".userId").text(),
                primaryDevice: element.find(".device").text(),
                cluster: element.find(".cluster").text()
            },
            beforeSend: function( data ) {
                element.find(".status").html( "<strong style='color: grey'>Sending</strong>" );
            },
            success: function( data, status ) {
                if (data.success) {
                    var color = 'green';
                    var status = 'Success';
                } else {
                    var color = 'red';
                    var status = 'Fail'
                }
                console.log(data.code);
                element.find(".status").html( "<strong style='color: " + color + "'>" + status + "</strong>" );
                element.find(".message").html( "<strong style='color: " + color + "'>" +  data.message + "</strong>" );
                element.find(".code").html( "<strong style='color: " + color + "'>" +  data.code + "</strong>" );
            },
            error: function( data ) {
                console.log(data);
                element.find(".status").html( "<strong style='color: red'>Error</strong>" );
                element.find(".message").html( "<strong style='color: red'>Ajax Error</strong>" );
            }
        });
    });
});


/*
ajax function for removing CIPC
 */
$(function(){
    $(".requestRowCipc").each( function() {
        var element = $(this);
        $.ajax({
            url: "ajax/removeCipc.php",
            type: "POST",
            dataType : 'json',
            async: false,
            data: {
                cipc: element.find(".cipc").text(),
                cluster: element.find(".cluster").text()
            },
            beforeSend: function( data ) {
                element.find(".status").html( "<strong style='color: grey'>Sending</strong>" );
            },
            success: function( data, status ) {
                if (data.success) {
                    var color = 'green';
                    var status = 'Success';
                } else {
                    var color = 'red';
                    var status = 'Fail'
                }
                console.log(data.code);
                element.find(".status").html( "<strong style='color: " + color + "'>" + status + "</strong>" );
                element.find(".message").html( "<strong style='color: " + color + "'>" +  data.message + "</strong>" );
                element.find(".code").html( "<strong style='color: " + color + "'>" +  data.code + "</strong>" );
            },
            error: function( data ) {
                console.log(data);
                element.find(".status").html( "<strong style='color: red'>Fail</strong>" );
                element.find(".message").html( "<strong style='color: red'>" + data.responseText + "</strong>" );
            }
        });
    });
});

/*
 ajax function for updating device descriptions
 */
$(function(){
    $(".requestRowDescription").each( function() {
        var element = $(this);
        $.ajax({
            url: "ajax/updateDescription.php",
            type: "POST",
            async: false,
            dataType : 'json',
            data: {
                device: element.find(".device").text(),
                description: element.find(".description").text(),
                cluster: element.find(".cluster").text()
            },
            beforeSend: function( data ) {
                element.find(".status").html( "<strong style='color: grey'>Sending</strong>" );
            },
            success: function( data, status ) {
                if (data.success) {
                    var color = 'green';
                    var status = 'Success';
                } else {
                    var color = 'red';
                    var status = 'Fail'
                }
                console.log(data.code);
                element.find(".status").html( "<strong style='color: " + color + "'>" + status + "</strong>" );
                element.find(".message").html( "<strong style='color: " + color + "'>" +  data.message + "</strong>" );
                element.find(".code").html( "<strong style='color: " + color + "'>" +  data.code + "</strong>" );
            },
            error: function( data ) {
                console.log(data);
                element.find(".status").html( "<strong style='color: red'>Fail</strong>" );
                element.find(".message").html( "<strong style='color: red'>" + data.responseText + "</strong>" );
            }
        });
    });
});

/*
 ajax function for getting device pool names
 */
$(function(){
    $(".requestRowDp").each( function() {
        var element = $(this);
        $.ajax({
            url: "ajax/getDevicePool.php",
            type: "POST",
            dataType : 'json',
            async: false,
            data: {
                device: element.find(".device").text(),
                cluster: element.find(".cluster").text()
            },
            beforeSend: function( data ) {
                element.find(".status").html( "<strong style='color: grey'>Sending</strong>" );
            },
            success: function( data, status ) {
                if (data.success) {
                    var color = 'green';
                    var status = 'Success';
                } else {
                    var color = 'red';
                    var status = 'Fail'
                }
                console.log(data.code);
                element.find(".status").html( "<strong style='color: " + color + "'>" + status + "</strong>" );
                element.find(".message").html( "<strong style='color: " + color + "'>" +  data.message + "</strong>" );
                element.find(".code").html( "<strong style='color: " + color + "'>" +  data.code + "</strong>" );
            },
            error: function( data ) {
                console.log(data);
                element.find(".status").html( "<strong style='color: red'>Fail</strong>" );
                element.find(".message").html( "<strong style='color: red'>" + data.responseText + "</strong>" );
            }
        });
    });
});

$(function(){
   $(".hide").hide();
});