$.datepicker.regional['fr'] = {
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
    monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin','Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
    dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
    dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
    dayNamesMin: ['D','L','M','M','J','V','S'],
    weekHeader: 'Sem.',
    dateFormat: 'dd-mm-yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''};

$.datepicker.setDefaults($.datepicker.regional['fr']);


function disableDayAndDates(date) {

    var m = date.getMonth();
    var d = date.getDay();
    var currDate = date.getDate();

    var heure   = ('0'+now.getHours()  ).slice(-2);

    if (d === 2 || d===0) {

        return [false] ;

    }else if (currDate === 1 && (m === 10 || m === 4)){
        return [false];
    }else if (currDate === 25 && m === 11){
        return [false];
    }
    else {

        return [true] ;
    }

}

var now = new Date();

var timeCond = now.getHours() >= 18;

$(function() {

    $( ".datepicker").datepicker({
        minDate: timeCond ? 1 : 0,
        changeMonth: true,
        changeYear: true,
        beforeShowDay: disableDayAndDates,

    });
});