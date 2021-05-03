


var PANEL = function(){
    this.timeReload = null;
    this.dataPanel = null;
    this.stage = 'default';

    this.voting = null;

    this.start = function () {
        setTimeout(this.getData(), 1000);
    }

    this.getData = function () {

        console.log("lucas")
        $.ajax({
            url: '/get-stage-panel',
            method: 'GET',
            async: false,
        }).success(function (data) {
            data = JSON.parse(data);
            console.log(data);
            loadPanel(data.stage)
        })

    }
}


var loadPanel = function (stage) {

    console.log(stage)

    $('.stage').hide();

    switch (stage) {
        case "voting":
            $('#voting').show();
            // var voting = new PVOTING();
            // voting.timeReload = setInterval(function () {
            //     voting.start();
            // },1000)
            break;
        case "resume":
            $('#resume').show();
            break;
        case "discourse":
            $('#discourse').show();
            break;
        default:
            $('#default').show();
    }
}

$(document).ready(function ()
{
    var panel = new PANEL();
    panel.start();

})

// // GLOBAL VAR
// var PANEL =  PANEL || {}
//
// PANEL.start = function() {
//     setInterval(function (args) {
//         this.general.getData();
//     }, 3000);
// }
//
// PANEL.general = {
//
//     timeReload: null,
//
//     stage: 'default',
//
//     stopPanel: function () {
//         clearInterval(this.timeReload)
//     },
//
//
//
//     getData: function() {
//         $.ajax({
//             url: '/get-stage-panel',
//             method: 'GET',
//         }).success(function (data) {
//             data = JSON.parse(data);
//             setStage(data.stage);
//         });
//     }
//
// }
//
// PANEL.default = {
//
//     //this.general.stopPanel();
//
// }
//
// PANEL.voting = {
//
//     url: "",
//
//     start: function () {
//
//     }
//
// }
//
// PANEL.resume = {
//
//     url: "",
//
//     start: function () {
//
//     }
//
// }
//
// PANEL.discourse = {
//
//     url: "",
//
//     start: function () {
//
//     }
//
// }
//
// $(document).ready(function ()
// {
//
//     var Panel = new PANEL();
//     console.info(Panel)
//
// })

