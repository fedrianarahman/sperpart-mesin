$(document).ready(function() {
    let data;

    function getMonthName(monthIndex) {
        var months = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        return months[monthIndex];
    }

    function getMonthIndex(monthName) {
        var months = {
            Jan: 0,
            Feb: 1,
            Mar: 2,
            Apr: 3,
            May: 4,
            Jun: 5,
            Jul: 6,
            Aug: 7,
            Sep: 8,
            Oct: 9,
            Nov: 10,
            Dec: 11
        };
        return months[monthName];
    }

    $.ajax({
        type: "GET",
        url: "./controller/permintaan/jumlahPermintaan.php",
        dataType: "json",
        success: function(response) {
            data = response.data;

            var groupedData = data.reduce(function(acc, entry) {
                var month = new Date(entry.createdAt).getMonth();
                acc[month] = (acc[month] || 0) + 1;
                return acc;
            }, {});

            var months = Array.from({
                length: 12
            }, (_, i) => getMonthName(i));
            var counts = months.map(month => groupedData[getMonthIndex(month)] || 0);
            console.log("Months:", months);
            console.log("Counts:", counts);

            var options = {
                series: [{
                    name: 'Total',
                    data: counts    
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val ;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },

                xaxis: {
                    categories: months,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return `${val} Permintaan`;
                        }
                    }

                },
                title: {
                    text: 'List Jumlah Permintaan 2023',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-permintaan"), options);
            chart.render();
        }
    });
});