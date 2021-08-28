

// Dashboard 1 Morris-chart
Morris.Area({
        element: 'morris-area-chart2',
        data: [{
            period: '2010',
            OPD: 0,
            ICU: 0,
            
        }, {
            period: '2011',
            OPD: 130,
            ICU: 100,
            
        }, {
            period: '2012',
            OPD: 30,
            ICU: 60,
            
        }, {
            period: '2013',
            OPD: 30,
            ICU: 200,
            
        }, {
            period: '2014',
            OPD: 200,
            ICU: 150,
            
        }, {
            period: '2015',
            OPD: 105,
            ICU: 90,
            
        },
         {
            period: '2016',
            OPD: 250,
            ICU: 150,
           
        }],
        xkey: 'period',
        ykeys: ['OPD', 'ICU'],
        labels: ['OPD $', 'ICU $'],
        pointSize: 0,
        fillOpacity: 0.4,
        pointStrokeColors:['#b4becb', '#00c292'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: false,
        hideHover: 'auto',
        lineColors: ['#b4becb', '#00c292'],
        resize: true
        
    });
Morris.Bar({
        element: 'morris-area-chart1',
        data: [{
            period: '2010',
            OPD: 40,
            ICU: 50,
            
        }, {
            period: '2011',
            OPD: 130,
            ICU: 100,
            
        }, {
            period: '2012',
            OPD: 30,
            ICU: 60,
            
        }, {
            period: '2013',
            OPD: 30,
            ICU: 200,
            
        }, {
            period: '2014',
            OPD: 200,
            ICU: 150,
            
        }, {
            period: '2015',
            OPD: 105,
            ICU: 90,
            
        },
         {
            period: '2016',
            OPD: 250,
            ICU: 150,
           
        }],
        xkey: 'period',
        ykeys: ['OPD', 'ICU'],
        labels: ['OPD', 'ICU'],
        pointSize: 0,
       
        pointStrokeColors:['#469fb4', '#01c0c8'],
        barColors:['#469fb4', '#01c0c8'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: false,
        hideHover: 'auto',
        lineColors: ['#469fb4', '#01c0c8'],
        resize: true
        
    });

 
$("#sparkline8").sparkline([2,4,4,6,8,5,6,4,8,6,6,2 ], {
            type: 'line',
            width: '100%',
            height: '130',
            lineColor: '#00c292',
            fillColor: 'rgba(0, 194, 146, 0.2)',
            maxSpotColor: '#00c292',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#00c292'
        });
        $("#sparkline9").sparkline([2,4,8,6,8,5,6,4,8,6,6,2 ], {
            type: 'line',
            width: '100%',
            height: '130',
            lineColor: '#03a9f3',
            fillColor: 'rgba(3, 169, 243, 0.2)',
            minSpotColor:'#03a9f3',
            maxSpotColor: '#03a9f3',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#03a9f3'
        });
        $("#sparkline10").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
            type: 'line',
            width: '100%',
            height: '130',
            lineColor: '#fb9678',
            fillColor: 'rgba(251, 150, 120, 0.2)',
            maxSpotColor: '#fb9678',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#fb9678'
        });

        $("#chart-container").insertFusionCharts({
            type: "scrollbar2d",
            width: "100%",
            height: "100%",
            dataFormat: "json",
            dataSource: {
              chart: {
                caption: "Top 25 NPM Packages for Node.js Developers",
                subcaption: "March 2019 ",
                plottooltext: "$dataValue Downloads",
                yaxisname: "Number of Downloads",
                xaxisname: "Packages",
                theme: "candy"
              },
              categories: [
                {
                  category: [
                    {
                      label: "Commander.js"
                    },
                    {
                      label: "Async.js"
                    },
                    {
                      label: "Request"
                    },
                    {
                      label: "Express"
                    },
                    {
                      label: "WebPack"
                    },
                    {
                      label: "Underscore"
                    },
                    {
                      label: "React"
                    },
                    {
                      label: "JSDom"
                    },
                    {
                      label: "Cheerio"
                    },
                    {
                      label: "Mocha"
                    },
                    {
                      label: "Marked"
                    },
                    {
                      label: "LESS"
                    },
                    {
                      label: "Morgan"
                    },
                    {
                      label: "Karma"
                    },
                    {
                      label: "MongoDB Driver"
                    },
                    {
                      label: "Nodemailer"
                    },
                    {
                      label: "Passport"
                    },
                    {
                      label: "Browserify"
                    },
                    {
                      label: "Grunt"
                    },
                    {
                      label: "JSHint"
                    },
                    {
                      label: "Angular"
                    },
                    {
                      label: "Bower"
                    },
                    {
                      label: "Pug"
                    },
                    {
                      label: "PM2"
                    },
                    {
                      label: "Hapi"
                    }
                  ]
                }
              ],
              dataset: [
                {
                  data: [
                    {
                      value: "97294205"
                    },
                    {
                      value: "95482197"
                    },
                    {
                      value: "60224172"
                    },
                    {
                      value: "33018247"
                    },
                    {
                      value: "31615028"
                    },
                    {
                      value: "28984878"
                    },
                    {
                      value: "25391784"
                    },
                    {
                      value: "23581733"
                    },
                    {
                      value: "12321215"
                    },
                    {
                      value: "10838161"
                    },
                    {
                      value: "7808888"
                    },
                    {
                      value: "7127519"
                    },
                    {
                      value: "6659395"
                    },
                    {
                      value: "5731933"
                    },
                    {
                      value: "4843888"
                    },
                    {
                      value: "3264090"
                    },
                    {
                      value: "2755188"
                    },
                    {
                      value: "2661761"
                    },
                    {
                      value: "2371272"
                    },
                    {
                      value: "2201511"
                    },
                    {
                      value: "1821149"
                    },
                    {
                      value: "1683996"
                    },
                    {
                      value: "1602832"
                    },
                    {
                      value: "1267422"
                    },
                    {
                      value: "1042206"
                    }
                  ]
                }
              ]
            }
          });