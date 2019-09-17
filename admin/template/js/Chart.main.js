if (location.href.indexOf('stat/today') != -1) {
    $('[href$="stat/today"]').addClass('active');
} else if (location.href.indexOf('stat/yesterday') != -1) {
    $('[href$="stat/yesterday"]').addClass('active');
} else if (location.href.indexOf('stat/month') != -1) {
    $('[href$="stat/month"]').addClass('active');
} else if (location.href.indexOf('stat/year') != -1) {
    $('[href$="stat/year"]').addClass('active');
} else if (location.href.indexOf('stat/region') != -1) {
    $('[href$="stat/region"]').addClass('active');
}

$('.stat-tabs a').click(function() {
    location.href = $(this).attr('href');
});

var borderWidthProp = 3;

var chartDay = function(id) {
    var id = id || "myChartDay";
    var ctx = document.getElementById(id);
    if (ctx != null) {
        var myChart = new Chart(ctx, {
            type: 'line',
            fill: 'start',
            lineJoin: 'round',
            data: {
                labels: [
                    "00:00 - 01:00",
                    "01:00 - 02:00",
                    "02:00 - 03:00",
                    "03:00 - 04:00",
                    "04:00 - 05:00",
                    "05:00 - 06:00",
                    "06:00 - 07:00",
                    "07:00 - 08:00",
                    "08:00 - 09:00",
                    "09:00 - 10:00",
                    "10:00 - 11:00",
                    "11:00 - 12:00",
                    "12:00 - 13:00",
                    "13:00 - 14:00",
                    "14:00 - 15:00",
                    "15:00 - 16:00",
                    "16:00 - 17:00",
                    "17:00 - 18:00",
                    "18:00 - 19:00",
                    "19:00 - 20:00",
                    "20:00 - 21:00",
                    "21:00 - 22:00",
                    "22:00 - 23:00",
                    "23:00 - 00:00"
                ],
                datasets: [{
                    label: 'Посетители по часам',
                    data: dataDayUsers,
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgba(255,99,132, 0.75)',
                    borderWidth: borderWidthProp,
                },
                {
                    label: 'Просмотры по часам',
                    data: dataDayViews,
                    backgroundColor: 'rgba(3,155,229,0.3)',
                    borderColor: 'rgba(3,155,229,0.75)',
                    borderWidth: borderWidthProp
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.0001
                    }
                }
            }
        });
    }
};
chartDay();

var generateDaysLabel = function() {
    var countDay = new Date().daysInMonth();
    var arrayLabel = [];
    for (var i = 0; i < countDay; i++) {
        arrayLabel.push(i + 1);
    }

    return arrayLabel;
};

var chartMonth = function(id) {
    var id = id || "myChartMonth";
    var ctx = document.getElementById(id);
    if (ctx != null)  {
        var labelsArr = generateDaysLabel();
        var myChart = new Chart(ctx, {
            type: 'line',
            fill: 'start',
            lineJoin: 'round',
            data: {
                labels: labelsArr,
                datasets: [{
                    label: 'Посетители по дням',
                    data: dataMonthUsers,
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgba(255,99,132, 0.75)',
                    borderWidth: borderWidthProp,
                },
                {
                    label: 'Просмотры по дням',
                    data: dataMonthViews,
                    backgroundColor: 'rgba(3,155,229,0.3)',
                    borderColor: 'rgba(3,155,229,0.75)',
                    borderWidth: borderWidthProp
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.000001
                    }
                }
            }
        });
    }
};
chartMonth();

var chartYear = function(id) {
    var id = id || "myChartYear";
    var ctx = document.getElementById(id);
    if (ctx != null) {
        var myChart = new Chart(ctx, {
            type: 'line',
            fill: 'start',
            lineJoin: 'round',
            data: {
                labels: [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                datasets: [{
                    label: 'Посетители по месяцам',
                    data: dataYearUsers,
                    backgroundColor: 'rgba(255, 99, 132, 0.3)',
                    borderColor: 'rgba(255,99,132, 0.75)',
                    borderWidth: borderWidthProp,
                },
                {
                    label: 'Просмотры по месяцам',
                    data: dataYearViews,
                    backgroundColor: 'rgba(3,155,229,0.3)',
                    borderColor: 'rgba(3,155,229,0.75)',
                    borderWidth: borderWidthProp
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.000001
                    }
                }
            }
        });
    }
};
chartYear();

var chartRegion = function() {
    var ctx = document.getElementById("myChartRegion");
    if (ctx != null) {
        var myChart = new Chart(ctx, configCharRegion);
    }
};
chartRegion();